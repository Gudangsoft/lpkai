<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Halaman extends Model
{
    protected $table = 'halamans';

    protected $fillable = ['judul', 'slug', 'konten', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
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
        return $query->where('aktif', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
