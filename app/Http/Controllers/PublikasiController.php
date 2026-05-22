<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Models\KategoriPublikasi;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $kategori  = $request->get('kategori', 'semua');
        $query     = Publikasi::aktif()->whereNotIn('kategori', ['Jurnal Ilmiah']);

        if ($kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        $publikasis  = $query->paginate(9)->appends(['kategori' => $kategori]);
        try {
            $kategoris = KategoriPublikasi::aktif()->orderBy('urutan')->get();
        } catch (\Exception $e) {
            $kategoris = collect();
        }

        $countPerKat = Publikasi::where('aktif', true)
            ->whereNotIn('kategori', ['Jurnal Ilmiah'])
            ->selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('publikasi', compact('publikasis', 'kategori', 'kategoris', 'countPerKat'));
    }

    public function show(Publikasi $publikasi)
    {
        abort_if(! $publikasi->aktif, 404);
        $related = Publikasi::aktif()
            ->where('kategori', $publikasi->kategori)
            ->where('id', '!=', $publikasi->id)
            ->latest()
            ->take(3)
            ->get();
        return view('publikasi-detail', compact('publikasi', 'related'));
    }
}
