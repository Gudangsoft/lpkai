<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use App\Models\Profile;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::aktif()->paginate(9);
        $profile    = Profile::first();
        return view('testimoni', compact('testimonis', 'profile'));
    }
}
