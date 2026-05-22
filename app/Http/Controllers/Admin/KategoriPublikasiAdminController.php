<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPublikasi;
use Illuminate\Http\Request;

class KategoriPublikasiAdminController extends Controller
{
    public function index()
    {
        $kategoris = KategoriPublikasi::orderBy('urutan')->orderBy('nama')->get();
        return view('admin.kategori-publikasi.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:100|unique:publikasi_kategoris,nama',
            'urutan' => 'nullable|integer|min:0',
        ]);

        KategoriPublikasi::create([
            'nama'   => $request->nama,
            'urutan' => $request->urutan ?? 0,
            'aktif'  => true,
        ]);

        return redirect()->route('admin.kategori-publikasi.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriPublikasi $kategoriPublikasi)
    {
        $request->validate([
            'nama'   => 'required|string|max:100|unique:publikasi_kategoris,nama,' . $kategoriPublikasi->id,
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
        ]);

        $kategoriPublikasi->update([
            'nama'   => $request->nama,
            'urutan' => $request->urutan ?? 0,
            'aktif'  => $request->boolean('aktif', true),
        ]);

        return redirect()->route('admin.kategori-publikasi.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriPublikasi $kategoriPublikasi)
    {
        $kategoriPublikasi->delete();
        return redirect()->route('admin.kategori-publikasi.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
