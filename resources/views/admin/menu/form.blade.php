@extends('layouts.admin')
@section('title', $menu->exists ? 'Edit Menu' : 'Tambah Menu')
@section('content')
<div class="admin-page-header">
    <h1>{{ $menu->exists ? 'Edit Menu' : 'Tambah Menu' }}</h1>
    <a href="{{ route('admin.menu.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="admin-form-card" style="max-width:700px;">
    <form action="{{ $menu->exists ? route('admin.menu.update', $menu) : route('admin.menu.store') }}" method="POST">
        @csrf
        @if($menu->exists) @method('PUT') @endif

        <div class="form-group">
            <label class="form-label">Label Menu <span>*</span></label>
            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label', $menu->label) }}" required>
            @error('label')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Tipe Tautan <span>*</span></label>
            <select name="type" id="menuType" class="form-control @error('type') is-invalid @enderror" onchange="toggleMenuTypeFields(this.value)" required>
                <option value="route" {{ old('type', $menu->type) == 'route' ? 'selected' : '' }}>Halaman Bawaan (mis. Layanan, Publikasi)</option>
                <option value="halaman" {{ old('type', $menu->type) == 'halaman' ? 'selected' : '' }}>Halaman Kustom</option>
                <option value="external" {{ old('type', $menu->type) == 'external' ? 'selected' : '' }}>Tautan Luar (URL)</option>
            </select>
            @error('type')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group" id="fieldRoute">
            <label class="form-label">Pilih Halaman Bawaan <span>*</span></label>
            <select name="route_name" class="form-control @error('route_name') is-invalid @enderror">
                <option value="">Pilih...</option>
                @php
                    $routeLabels = [
                        'beranda' => 'Beranda', 'tentang-kami' => 'Tentang Kami', 'layanan' => 'Layanan',
                        'pengalaman' => 'Pengalaman', 'klien-mitra' => 'Klien/Mitra', 'testimoni' => 'Testimoni',
                        'publikasi' => 'Publikasi', 'berita' => 'Berita', 'kontak' => 'Kontak',
                    ];
                @endphp
                @foreach($routeLabels as $name => $lbl)
                <option value="{{ $name }}" {{ old('route_name', $menu->route_name) == $name ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
            @error('route_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group" id="fieldHalaman">
            <label class="form-label">Pilih Halaman Kustom <span>*</span></label>
            <select name="halaman_id" class="form-control @error('halaman_id') is-invalid @enderror">
                <option value="">Pilih...</option>
                @foreach($halamans as $id => $judul)
                <option value="{{ $id }}" {{ old('halaman_id', $menu->halaman_id) == $id ? 'selected' : '' }}>{{ $judul }}</option>
                @endforeach
            </select>
            @error('halaman_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            @if($halamans->isEmpty())
            <small style="color:#718096;margin-top:4px;display:block;">Belum ada halaman kustom. <a href="{{ route('admin.halaman.create') }}">Buat halaman baru</a>.</small>
            @endif
        </div>

        <div class="form-group" id="fieldExternal">
            <label class="form-label">URL Tujuan <span>*</span></label>
            <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $menu->url) }}" placeholder="https://...">
            @error('url')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Induk Menu (Submenu dari)</label>
                @if($menu->exists && $menu->children()->exists())
                <select class="form-control" disabled>
                    <option>— Tidak bisa diatur, menu ini punya submenu —</option>
                </select>
                <input type="hidden" name="parent_id" value="">
                @else
                <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                    <option value="">— Tidak ada (menu utama) —</option>
                    @foreach($topLevelMenus as $m)
                    <option value="{{ $m->id }}" {{ old('parent_id', $menu->parent_id) == $m->id ? 'selected' : '' }}>{{ $m->label }}</option>
                    @endforeach
                </select>
                @endif
                @error('parent_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                <small style="color:#718096;">Menu yang sudah punya submenu tidak muncul di daftar ini.</small>
            </div>
            <div class="form-group">
                <label class="form-label">Buka Tautan</label>
                <select name="target" class="form-control">
                    <option value="_self" {{ old('target', $menu->target) == '_self' ? 'selected' : '' }}>Tab yang sama</option>
                    <option value="_blank" {{ old('target', $menu->target) == '_blank' ? 'selected' : '' }}>Tab baru</option>
                </select>
            </div>
        </div>

        <div class="form-check">
            <input type="checkbox" name="is_button" id="is_button" value="1" {{ old('is_button', $menu->is_button) ? 'checked' : '' }}>
            <label for="is_button">Tampilkan sebagai tombol (gaya CTA, seperti "Kontak")</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $menu->aktif ?? true) ? 'checked' : '' }}>
            <label for="aktif">Tampilkan di menu</label>
        </div>

        <div style="margin-top:24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function toggleMenuTypeFields(type) {
    document.getElementById('fieldRoute').style.display = type === 'route' ? 'block' : 'none';
    document.getElementById('fieldHalaman').style.display = type === 'halaman' ? 'block' : 'none';
    document.getElementById('fieldExternal').style.display = type === 'external' ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', function () {
    toggleMenuTypeFields(document.getElementById('menuType').value);
});
</script>
@endpush
@endsection
