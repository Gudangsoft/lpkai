@extends('layouts.admin')
@section('title', $berita->exists ? 'Edit Berita' : 'Tambah Berita')
@section('content')
<div class="admin-page-header">
    <h1>{{ $berita->exists ? 'Edit Berita' : 'Tambah Berita' }}</h1>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="admin-form-card" style="max-width:860px;">
    <form action="{{ $berita->exists ? route('admin.berita.update', $berita) : route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($berita->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Judul Berita <span>*</span></label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $berita->judul) }}" required>
            @error('judul')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $berita->penulis) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $berita->tanggal ? $berita->tanggal->format('Y-m-d') : date('Y-m-d')) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Ringkasan Singkat</label>
            <textarea name="ringkasan" class="form-control" rows="3">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Konten Lengkap</label>
            <textarea name="konten" class="form-control" rows="8">{{ old('konten', $berita->konten) }}</textarea>
            <small style="color:#718096;">Mendukung format HTML atau teks panjang.</small>
        </div>
        <div class="form-group">
            <label class="form-label">Gambar Sampul</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" data-preview="prevGambar">
            @if($berita->gambar)
            <img id="prevGambar" src="{{ Storage::url($berita->gambar) }}" class="img-preview" style="max-height: 150px; margin-top: 10px;">
            @else
            <img id="prevGambar" class="img-preview" style="display:none; max-height: 150px; margin-top: 10px;">
            @endif
        </div>
        <div class="form-check">
            <input type="checkbox" name="unggulan" id="unggulan" value="1" {{ old('unggulan', $berita->unggulan) ? 'checked' : '' }}>
            <label for="unggulan">Jadikan Berita Unggulan</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $berita->aktif ?? true) ? 'checked' : '' }}>
            <label for="aktif">Tampilkan di website</label>
        </div>
        <div style="margin-top:24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
