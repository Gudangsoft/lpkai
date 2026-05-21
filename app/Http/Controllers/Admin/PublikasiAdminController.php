<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublikasiAdminController extends Controller
{
    public function index()
    {
        $publikasis = Publikasi::latest()->paginate(15);
        return view('admin.publikasi.index', compact('publikasis'));
    }

    public function create()
    {
        $kategoriList = ['Buku', 'Artikel', 'Berita Kegiatan', 'Foto/Video Kegiatan'];
        return view('admin.publikasi.form', ['publikasi' => new Publikasi, 'kategoriList' => $kategoriList]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:300',
            'kategori'       => 'required|in:Buku,Artikel,Berita Kegiatan,Foto/Video Kegiatan',
            'penulis'        => 'nullable|string|max:200',
            'deskripsi'      => 'nullable|string',
            'konten'         => 'nullable|string',
            'video_url'      => 'nullable|url|max:300',
            'tanggal_terbit' => 'nullable|date',
            'unggulan'       => 'nullable|boolean',
            'aktif'          => 'nullable|boolean',
            'gambar'         => 'nullable|image|max:4096',
            'file_upload'    => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $validated['unggulan'] = $request->boolean('unggulan');
        $validated['aktif']    = $request->boolean('aktif', true);
        $validated['slug']     = Str::slug($request->judul) . '-' . time();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('publikasi', 'public');
        }
        if ($request->hasFile('file_upload')) {
            $validated['file_url'] = $request->file('file_upload')->store('publikasi/files', 'public');
        }

        $galeri = [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $galeri[] = $file->store('publikasi/galeri', 'public');
            }
        }
        $validated['galeri'] = empty($galeri) ? null : $galeri;

        Publikasi::create($validated);
        return redirect()->route('admin.publikasi.index')->with('success', 'Publikasi berhasil ditambahkan.');
    }

    public function edit(Publikasi $publikasi)
    {
        $kategoriList = ['Buku', 'Artikel', 'Berita Kegiatan', 'Foto/Video Kegiatan'];
        return view('admin.publikasi.form', compact('publikasi', 'kategoriList'));
    }

    public function update(Request $request, Publikasi $publikasi)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:300',
            'kategori'       => 'required|in:Buku,Artikel,Berita Kegiatan,Foto/Video Kegiatan',
            'penulis'        => 'nullable|string|max:200',
            'deskripsi'      => 'nullable|string',
            'konten'         => 'nullable|string',
            'video_url'      => 'nullable|url|max:300',
            'tanggal_terbit' => 'nullable|date',
            'unggulan'       => 'nullable|boolean',
            'aktif'          => 'nullable|boolean',
            'gambar'         => 'nullable|image|max:4096',
            'galeri.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'remove_galeri'  => 'nullable|array',
            'file_upload'    => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $validated['unggulan'] = $request->boolean('unggulan');
        $validated['aktif']    = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            if ($publikasi->gambar) Storage::disk('public')->delete($publikasi->gambar);
            $validated['gambar'] = $request->file('gambar')->store('publikasi', 'public');
        }
        if ($request->hasFile('file_upload')) {
            if ($publikasi->file_url) Storage::disk('public')->delete($publikasi->file_url);
            $validated['file_url'] = $request->file('file_upload')->store('publikasi/files', 'public');
        }

        $galeri = is_array($publikasi->galeri) ? $publikasi->galeri : [];
        if ($request->has('remove_galeri')) {
            foreach ($request->input('remove_galeri') as $fileToRemove) {
                if (($key = array_search($fileToRemove, $galeri)) !== false) {
                    Storage::disk('public')->delete($fileToRemove);
                    unset($galeri[$key]);
                }
            }
            $galeri = array_values($galeri);
        }
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $galeri[] = $file->store('publikasi/galeri', 'public');
            }
        }
        $validated['galeri'] = empty($galeri) ? null : $galeri;

        $publikasi->update($validated);
        return redirect()->route('admin.publikasi.index')->with('success', 'Publikasi berhasil diperbarui.');
    }

    public function destroy(Publikasi $publikasi)
    {
        if ($publikasi->gambar) Storage::disk('public')->delete($publikasi->gambar);
        if ($publikasi->file_url) Storage::disk('public')->delete($publikasi->file_url);
        foreach ((is_array($publikasi->galeri) ? $publikasi->galeri : []) as $img) {
            Storage::disk('public')->delete($img);
        }
        $publikasi->delete();
        return redirect()->route('admin.publikasi.index')->with('success', 'Publikasi berhasil dihapus.');
    }
}
