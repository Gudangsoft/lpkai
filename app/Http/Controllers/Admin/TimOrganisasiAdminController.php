<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimOrganisasiAdminController extends Controller
{
    public function index()
    {
        $tims = TimOrganisasi::orderBy('kelompok')->orderBy('urutan')->orderBy('nama')->get();
        return view('admin.tim-organisasi.index', compact('tims'));
    }

    public function create()
    {
        return view('admin.tim-organisasi.form', ['tim' => new TimOrganisasi]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelompok' => 'required|in:Tim Pengurus,Tim Pembina,Tim Pengawas,Tim Tenaga Ahli',
            'nama'     => 'required|string|max:200',
            'jabatan'  => 'required|string|max:200',
            'bio'      => 'nullable|string',
            'keahlian' => 'nullable|string',
            'foto'     => 'nullable|image|max:2048',
            'email'    => 'nullable|email|max:150',
            'linkedin' => 'nullable|url|max:300',
            'urutan'   => 'nullable|integer|min:0',
            'aktif'    => 'nullable|boolean',
        ]);
        $validated['aktif']  = $request->boolean('aktif', true);
        $validated['urutan'] = $request->input('urutan', 0);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('tim-organisasi', 'public');
        }

        TimOrganisasi::create($validated);
        return redirect()->route('admin.tim-organisasi.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TimOrganisasi $timOrganisasi)
    {
        return view('admin.tim-organisasi.form', ['tim' => $timOrganisasi]);
    }

    public function update(Request $request, TimOrganisasi $timOrganisasi)
    {
        $validated = $request->validate([
            'kelompok' => 'required|in:Tim Pengurus,Tim Pembina,Tim Pengawas,Tim Tenaga Ahli',
            'nama'     => 'required|string|max:200',
            'jabatan'  => 'required|string|max:200',
            'bio'      => 'nullable|string',
            'keahlian' => 'nullable|string',
            'foto'     => 'nullable|image|max:2048',
            'email'    => 'nullable|email|max:150',
            'linkedin' => 'nullable|url|max:300',
            'urutan'   => 'nullable|integer|min:0',
            'aktif'    => 'nullable|boolean',
        ]);
        $validated['aktif']  = $request->boolean('aktif', true);
        $validated['urutan'] = $request->input('urutan', 0);

        if ($request->hasFile('foto')) {
            if ($timOrganisasi->foto) Storage::disk('public')->delete($timOrganisasi->foto);
            $validated['foto'] = $request->file('foto')->store('tim-organisasi', 'public');
        }

        $timOrganisasi->update($validated);
        return redirect()->route('admin.tim-organisasi.index')->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    public function toggleAktif(TimOrganisasi $timOrganisasi)
    {
        $timOrganisasi->update(['aktif' => ! $timOrganisasi->aktif]);
        return redirect()->route('admin.tim-organisasi.index')->with('success', 'Status tampil anggota tim berhasil diperbarui.');
    }

    public function destroy(TimOrganisasi $timOrganisasi)
    {
        if ($timOrganisasi->foto) Storage::disk('public')->delete($timOrganisasi->foto);
        $timOrganisasi->delete();
        return redirect()->route('admin.tim-organisasi.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
