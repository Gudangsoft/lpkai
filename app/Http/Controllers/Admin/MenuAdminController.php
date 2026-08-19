<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Halaman;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MenuAdminController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
            ->with(['children' => fn ($q) => $q->orderBy('urutan')])
            ->orderBy('urutan')
            ->get();
        $topLevelMenus = $menus; // valid `parent_id` picker options — already top-level only
        $halamans = Halaman::aktif()->orderBy('judul')->pluck('judul', 'id');

        return view('admin.menu.index', compact('menus', 'topLevelMenus', 'halamans'));
    }

    public function create()
    {
        $halamans = Halaman::aktif()->orderBy('judul')->pluck('judul', 'id');
        $topLevelMenus = Menu::whereNull('parent_id')->orderBy('urutan')->get();
        return view('admin.menu.form', ['menu' => new Menu, 'halamans' => $halamans, 'topLevelMenus' => $topLevelMenus]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateMenu($request);
        $this->guardParentDepth($validated['parent_id'] ?? null);

        $validated['urutan'] = (Menu::where('parent_id', $validated['parent_id'] ?? null)->max('urutan') ?? 0) + 1;

        Menu::create($validated);
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $halamans = Halaman::aktif()->orderBy('judul')->pluck('judul', 'id');
        $topLevelMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('urutan')->get();
        return view('admin.menu.form', compact('menu', 'halamans', 'topLevelMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $this->validateMenu($request);
        $this->guardParentDepth($validated['parent_id'] ?? null);

        if (($validated['parent_id'] ?? null) == $menu->id) {
            return back()->withInput()->withErrors(['parent_id' => 'Menu tidak bisa menjadi induk dirinya sendiri.']);
        }

        // An item that already has its own children can't become someone else's
        // child (would silently strand its children or require a 3rd level).
        if (($validated['parent_id'] ?? null) && $menu->children()->exists()) {
            return back()->withInput()->withErrors([
                'parent_id' => 'Menu ini memiliki sub-menu, tidak bisa dijadikan sub-menu dari menu lain. Pindahkan/hapus sub-menunya dulu.',
            ]);
        }

        $menu->update($validated);
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete(); // children cascade-delete at the DB level
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items'             => 'required|array',
            'items.*.id'        => 'required|integer|exists:menus,id',
            'items.*.parent_id' => 'nullable|integer|exists:menus,id',
            'items.*.urutan'    => 'required|integer|min:0',
        ]);

        // Defense in depth: reject the whole batch if any submitted parent_id
        // itself already has a parent (would create a 3rd nesting level).
        $parentIds = collect($validated['items'])->pluck('parent_id')->filter()->unique();
        if ($parentIds->isNotEmpty()) {
            $invalidParents = Menu::whereIn('id', $parentIds)->whereNotNull('parent_id')->exists();
            if ($invalidParents) {
                return response()->json(['message' => 'Struktur menu tidak valid (maksimal 2 level).'], 422);
            }
        }

        DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $item) {
                Menu::where('id', $item['id'])->update([
                    'parent_id' => $item['parent_id'] ?? null,
                    'urutan'    => $item['urutan'],
                ]);
            }
        });

        return response()->json(['message' => 'Urutan menu berhasil disimpan.']);
    }

    private function validateMenu(Request $request): array
    {
        $validated = $request->validate([
            'label'      => 'required|string|max:150',
            'type'       => ['required', Rule::in(['route', 'halaman', 'external'])],
            'route_name' => ['required_if:type,route', 'nullable', Rule::in(Menu::ROUTE_WHITELIST)],
            'halaman_id' => 'required_if:type,halaman|nullable|exists:halamans,id',
            'url'        => 'required_if:type,external|nullable|string|max:500',
            'parent_id'  => 'nullable|exists:menus,id',
            'is_button'  => 'nullable|boolean',
            'target'     => ['nullable', Rule::in(['_self', '_blank'])],
            'aktif'      => 'nullable|boolean',
        ]);

        $validated['is_button'] = $request->boolean('is_button');
        $validated['aktif']     = $request->boolean('aktif', true);
        $validated['target']    = $validated['target'] ?? '_self';

        // Only the fields relevant to the chosen type should be persisted.
        if ($validated['type'] !== 'route') $validated['route_name'] = null;
        if ($validated['type'] !== 'halaman') $validated['halaman_id'] = null;
        if ($validated['type'] !== 'external') $validated['url'] = null;

        return $validated;
    }

    private function guardParentDepth(?int $parentId): void
    {
        if (! $parentId) {
            return;
        }

        $parent = Menu::find($parentId);
        if ($parent && $parent->parent_id) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'parent_id' => 'Menu tersebut sudah berada di level ke-2, tidak bisa dijadikan induk.',
            ]);
        }
    }
}
