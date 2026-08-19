<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Halaman;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HalamanAdminController extends Controller
{
    public function index()
    {
        $halamans = Halaman::latest()->paginate(15);
        return view('admin.halaman.index', compact('halamans'));
    }

    public function create()
    {
        return view('admin.halaman.form', ['halaman' => new Halaman]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'  => 'required|string|max:300',
            'konten' => 'nullable|string',
            'aktif'  => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);
        $validated['slug']  = Str::slug($request->judul) . '-' . time();

        Halaman::create($validated);
        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function edit(Halaman $halaman)
    {
        return view('admin.halaman.form', compact('halaman'));
    }

    public function update(Request $request, Halaman $halaman)
    {
        $validated = $request->validate([
            'judul'  => 'required|string|max:300',
            'konten' => 'nullable|string',
            'aktif'  => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        $halaman->update($validated);
        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Halaman $halaman)
    {
        if (Menu::where('halaman_id', $halaman->id)->exists()) {
            return back()->with('error', 'Halaman ini masih dipakai oleh menu navigasi. Hapus atau ubah menu tersebut dulu sebelum menghapus halaman ini.');
        }

        $halaman->delete();
        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
