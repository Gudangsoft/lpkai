<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaAdminController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->paginate(15);
        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.berita.form', ['berita' => new Berita]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:300',
            'penulis'   => 'nullable|string|max:200',
            'ringkasan' => 'nullable|string',
            'konten'    => 'nullable|string',
            'tanggal'   => 'nullable|date',
            'unggulan'  => 'nullable|boolean',
            'aktif'     => 'nullable|boolean',
            'gambar'    => 'nullable|image|max:4096',
        ]);

        $validated['unggulan'] = $request->boolean('unggulan');
        $validated['aktif']    = $request->boolean('aktif', true);
        $validated['slug']     = Str::slug($request->judul) . '-' . time();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.form', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:300',
            'penulis'   => 'nullable|string|max:200',
            'ringkasan' => 'nullable|string',
            'konten'    => 'nullable|string',
            'tanggal'   => 'nullable|date',
            'unggulan'  => 'nullable|boolean',
            'aktif'     => 'nullable|boolean',
            'gambar'    => 'nullable|image|max:4096',
        ]);

        $validated['unggulan'] = $request->boolean('unggulan');
        $validated['aktif']    = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
