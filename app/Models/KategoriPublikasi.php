<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPublikasi extends Model
{
    protected $table    = 'publikasi_kategoris';
    protected $fillable = ['nama', 'urutan', 'aktif'];
    protected $casts    = ['aktif' => 'boolean'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
