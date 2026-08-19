<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Profile;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::aktif()->get();
        $profile = Profile::first();
        return view('layanan', compact('layanans', 'profile'));
    }

    public function show(Layanan $layanan)
    {
        abort_if(! $layanan->aktif, 404);
        $profile = Profile::first();
        $lainnya = Layanan::aktif()->where('id', '!=', $layanan->id)->take(3)->get();
        return view('layanan-detail', compact('layanan', 'profile', 'lainnya'));
    }
}
