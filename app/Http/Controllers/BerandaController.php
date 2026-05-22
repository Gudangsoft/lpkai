<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pengalaman;
use App\Models\Profile;
use App\Models\Publikasi;
use App\Models\Testimoni;

class BerandaController extends Controller
{
    public function index()
    {
        $profile    = Profile::first();
        $layanans   = Layanan::aktif()->take(3)->get();
        $pengalamans = Pengalaman::aktif()->where('unggulan', true)->take(4)->get();
        $testimonis = Testimoni::aktif()->take(3)->get();
        $publikasis = Publikasi::aktif()->whereNotIn('kategori', ['Jurnal Ilmiah'])->latest()->take(3)->get();
        $kliens     = \App\Models\KlienMitra::aktif()->get();

        return view('beranda', compact('profile', 'layanans', 'pengalamans', 'testimonis', 'publikasis', 'kliens'));
    }
}
