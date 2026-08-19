<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'beritas';

    protected $fillable = [
        'judul', 'slug', 'ringkasan', 'konten', 'gambar',
        'penulis', 'tanggal', 'unggulan', 'aktif',
    ];

    protected $casts = [
        'tanggal'  => 'date',
        'unggulan' => 'boolean',
        'aktif'    => 'boolean',
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
        return $query->where('aktif', true)->orderByDesc('tanggal');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
