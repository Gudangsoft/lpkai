<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publikasi extends Model
{
    protected $table = 'publikasis';

    protected $fillable = [
        'judul', 'kategori', 'penulis', 'deskripsi', 'konten',
        'gambar', 'galeri', 'file_url', 'video_url', 'slug',
        'tanggal_terbit', 'unggulan', 'aktif',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'unggulan'       => 'boolean',
        'aktif'          => 'boolean',
        'galeri'         => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul) . '-' . time();
            }
        });
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderByDesc('tanggal_terbit');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
