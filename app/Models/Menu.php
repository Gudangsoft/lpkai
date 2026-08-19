<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'label', 'type', 'route_name', 'halaman_id', 'url',
        'parent_id', 'urutan', 'is_button', 'target', 'aktif',
    ];

    protected $casts = [
        'is_button' => 'boolean',
        'aktif'     => 'boolean',
    ];

    public const ROUTE_WHITELIST = [
        'beranda', 'tentang-kami', 'layanan', 'pengalaman',
        'klien-mitra', 'testimoni', 'publikasi', 'berita', 'kontak',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('urutan');
    }

    public function halaman()
    {
        return $this->belongsTo(Halaman::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Method, not accessor — an accessor named url() would collide with the `url` column.
    public function resolveUrl(): string
    {
        return match ($this->type) {
            'route' => in_array($this->route_name, self::ROUTE_WHITELIST, true)
                ? route($this->route_name)
                : '#',
            'halaman' => $this->halaman && $this->halaman->aktif
                ? route('halaman.show', $this->halaman)
                : '#',
            'external' => $this->url ?: '#',
            default => '#',
        };
    }

    public function isActive(): bool
    {
        return match ($this->type) {
            'route' => in_array($this->route_name, self::ROUTE_WHITELIST, true)
                && request()->routeIs($this->route_name),
            'halaman' => request()->routeIs('halaman.show')
                && $this->halaman
                && request()->route('halaman')?->slug === $this->halaman->slug,
            default => false,
        };
    }
}
