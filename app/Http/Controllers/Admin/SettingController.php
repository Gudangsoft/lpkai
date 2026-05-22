<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        return view('admin.setting.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lembaga'      => 'nullable|string|max:200',
            'singkatan'         => 'nullable|string|max:30',
            'tagline'           => 'nullable|string|max:300',
            'deskripsi_singkat' => 'nullable|string|max:500',
            // Kontak
            'alamat'            => 'nullable|string|max:500',
            'telepon'           => 'nullable|string|max:50',
            'email'             => 'nullable|email|max:150',
            'website'           => 'nullable|url|max:200',
            'maps_embed'        => 'nullable|string',
            // Logo & Favicon
            'logo'              => 'nullable|image|max:2048',
            'favicon'           => 'nullable|image|max:512',
            // Social media
            'facebook'          => 'nullable|url|max:300',
            'instagram'         => 'nullable|url|max:300',
            'twitter'           => 'nullable|url|max:300',
            'youtube'           => 'nullable|url|max:300',
            'tiktok'            => 'nullable|url|max:300',
            'linkedin'          => 'nullable|url|max:300',
            'whatsapp'          => 'nullable|string|max:50',
            'telegram'          => 'nullable|string|max:200',
            'threads'           => 'nullable|url|max:300',
            // Footer
            'footer_slogan'     => 'nullable|string|max:300',
            'footer_copyright'  => 'nullable|string|max:200',
            // Journals
            'journals_gambar'     => 'nullable|image|max:3072',
            'journals_url'        => 'nullable|url|max:500',
            'journals_deskripsi'  => 'nullable|string|max:400',
            // Maintenance
            'maintenance_mode'  => 'nullable|boolean',
            'maintenance_pesan' => 'nullable|string|max:500',
        ]);

        $profile = Profile::firstOrCreate([]);

        $data = [
            'nama_lembaga'      => $request->input('nama_lembaga'),
            'singkatan'         => $request->input('singkatan'),
            'tagline'           => $request->input('tagline'),
            'deskripsi_singkat' => $request->input('deskripsi_singkat'),
            'alamat'            => $request->input('alamat'),
            'telepon'           => $request->input('telepon'),
            'email'             => $request->input('email'),
            'website'           => $request->input('website'),
            'maps_embed'        => $request->input('maps_embed'),
            'facebook'          => $request->input('facebook'),
            'instagram'         => $request->input('instagram'),
            'twitter'           => $request->input('twitter'),
            'youtube'           => $request->input('youtube'),
            'tiktok'            => $request->input('tiktok'),
            'linkedin'          => $request->input('linkedin'),
            'whatsapp'          => $request->input('whatsapp'),
            'telegram'          => $request->input('telegram'),
            'threads'           => $request->input('threads'),
            'footer_slogan'     => $request->input('footer_slogan'),
            'footer_copyright'  => $request->input('footer_copyright'),
            'journals_url'       => $request->input('journals_url'),
            'journals_deskripsi' => $request->input('journals_deskripsi'),
            'maintenance_mode'   => $request->boolean('maintenance_mode'),
            'maintenance_pesan'  => $request->input('maintenance_pesan'),
        ];

        if ($request->hasFile('logo')) {
            if ($profile->logo) Storage::disk('public')->delete($profile->logo);
            $data['logo'] = $request->file('logo')->store('profile', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($profile->favicon) Storage::disk('public')->delete($profile->favicon);
            $data['favicon'] = $request->file('favicon')->store('profile/favicon', 'public');
        }

        if ($request->hasFile('journals_gambar')) {
            if ($profile->journals_gambar) Storage::disk('public')->delete($profile->journals_gambar);
            $data['journals_gambar'] = $request->file('journals_gambar')->store('profile/journals', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
