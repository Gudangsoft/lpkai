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
            'judul'          => 'required|string|max:300',
            'penulis'        => 'nullable|string|max:200',
            'deskripsi'      => 'nullable|string',
            'konten'         => 'nullable|string',
            'video_url'      => 'nullable|url|max:300',
            'tanggal_terbit' => 'nullable|date',
            'unggulan'       => 'nullable|boolean',
            'aktif'          => 'nullable|boolean',
            'gambar'         => 'nullable|image|max:4096',
            'galeri.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'file_upload'    => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $validated['kategori'] = self::KATEGORI;
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
        return redirect()->route('admin.jurnal.index')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function edit(Publikasi $jurnal)
    {
        return view('admin.jurnal.form', ['publikasi' => $jurnal]);
    }

    public function update(Request $request, Publikasi $jurnal)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:300',
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

        $validated['kategori'] = self::KATEGORI;
        $validated['unggulan'] = $request->boolean('unggulan');
        $validated['aktif']    = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            if ($jurnal->gambar) Storage::disk('public')->delete($jurnal->gambar);
            $validated['gambar'] = $request->file('gambar')->store('publikasi', 'public');
        }
        if ($request->hasFile('file_upload')) {
            if ($jurnal->file_url) Storage::disk('public')->delete($jurnal->file_url);
            $validated['file_url'] = $request->file('file_upload')->store('publikasi/files', 'public');
        }

        $galeri = is_array($jurnal->galeri) ? $jurnal->galeri : [];
        if ($request->has('remove_galeri')) {
            foreach ($request->input('remove_galeri') as $f) {
                if (($key = array_search($f, $galeri)) !== false) {
                    Storage::disk('public')->delete($f);
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
