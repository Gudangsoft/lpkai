<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use App\Models\Profile;

class HalamanController extends Controller
{
    public function show(Halaman $halaman)
    {
        abort_if(! $halaman->aktif, 404);
        $profile = Profile::first();
        return view('halaman-detail', compact('halaman', 'profile'));
    }
}
