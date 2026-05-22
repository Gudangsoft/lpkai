<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'nama_lembaga', 'singkatan', 'tagline', 'deskripsi_singkat', 'footer_slogan', 'footer_copyright',
        'tentang_kami', 'sejarah', 'visi', 'misi',
        'sambutan_ketua_nama', 'sambutan_ketua_jabatan', 'sambutan_ketua_isi', 'foto_ketua',
        'logo', 'favicon', 'alamat', 'telepon', 'email', 'website',
        'facebook', 'instagram', 'twitter', 'youtube',
        'tiktok', 'linkedin', 'whatsapp', 'telegram', 'threads',
        'maps_embed', 'foto_struktur_organisasi', 'foto_tentang_kami',
        'foto_layanan', 'deskripsi_layanan', 'deskripsi_pengalaman',
        'hero_badge', 'hero_image', 'hero_images',
        'journals_gambar', 'journals_url', 'journals_deskripsi',
        'legalitas', 'maintenance_mode', 'maintenance_pesan',
    ];

    protected $casts = [
        'hero_images'      => 'array',
        'maintenance_mode' => 'boolean',
    ];
}
