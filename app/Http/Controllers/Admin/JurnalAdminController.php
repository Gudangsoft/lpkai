<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JurnalAdminController extends Controller
{
    private const KATEGORI = 'Jurnal Ilmiah';

    public function index(Request $request)
    {
        $q = $request->input('q');
        $jurnal = Publikasi::where('kategori', self::KATEGORI)
            ->when($q, fn($query) => $query->where(function ($s) use ($q) {
                $s->where('judul', 'like', "%{$q}%")
                  ->orWhere('penulis', 'like', "%{$q}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.jurnal.index', compact('jurnal', 'q'));
    }

    public function create()
    {
        return view('admin.jurnal.form', [
            'publikasi' => new Publikasi,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'  => 'required|string|max:300',
            'issn'   => 'nullable|string|max:100',
            'aktif'  => 'nullable|boolean',
            'gambar' => 'nullable|image|max:4096',
        ]);

        $validated['kategori'] = self::KATEGORI;
        $validated['aktif']    = $request->boolean('aktif', true);
        $validated['slug']     = Str::slug($request->judul) . '-' . time();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('publikasi/jurnal', 'public');
        }

        Publikasi::create($validated);
        return redirect()->route('admin.jurnal.index')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function edit(Publikasi $jurnal)
    {
        return view('admin.jurnal.form', ['publikasi' => $jurnal]);
    }

    public function update(Request $request, Publikasi $jurnal)
    {
        $validated = $request->validate([
            'judul'  => 'required|string|max:300',
            'issn'   => 'nullable|string|max:100',
            'aktif'  => 'nullable|boolean',
            'gambar' => 'nullable|image|max:4096',
        ]);

        $validated['kategori'] = self::KATEGORI;
        $validated['aktif']    = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            if ($jurnal->gambar) Storage::disk('public')->delete($jurnal->gambar);
            $validated['gambar'] = $request->file('gambar')->store('publikasi/jurnal', 'public');
        }

        $jurnal->update($validated);
        return redirect()->route('admin.jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Publikasi $jurnal)
    {
        if ($jurnal->gambar)   Storage::disk('public')->delete($jurnal->gambar);
        if ($jurnal->file_url) Storage::disk('public')->delete($jurnal->file_url);
        foreach ((is_array($jurnal->galeri) ? $jurnal->galeri : []) as $img) {
            Storage::disk('public')->delete($img);
        }
        $jurnal->delete();
        return redirect()->route('admin.jurnal.index')->with('success', 'Jurnal berhasil dihapus.');
    }
}
