<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Profile;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $q     = $request->get('q');
        $query = Berita::aktif();

        if ($q) {
            $query->where('judul', 'like', '%' . $q . '%');
        }

        $beritas = $query->paginate(9)->appends(['q' => $q]);
        $profile = Profile::first();

        return view('berita', compact('beritas', 'q', 'profile'));
    }

    public function show(Berita $berita)
    {
        abort_if(! $berita->aktif, 404);
        $related = Berita::aktif()
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(3)
            ->get();
        return view('berita-detail', compact('berita', 'related'));
    }
}
