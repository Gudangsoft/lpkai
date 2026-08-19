@extends('layouts.admin')
@section('title', $halaman->exists ? 'Edit Halaman' : 'Tambah Halaman')
@section('content')
<div class="admin-page-header">
    <h1>{{ $halaman->exists ? 'Edit Halaman' : 'Tambah Halaman' }}</h1>
    <a href="{{ route('admin.halaman.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="admin-form-card" style="max-width:860px;">
    <form action="{{ $halaman->exists ? route('admin.halaman.update', $halaman) : route('admin.halaman.store') }}" method="POST">
        @csrf
        @if($halaman->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Judul Halaman <span>*</span></label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $halaman->judul) }}" required>
            @error('judul')<span class="invalid-feedback">{{ $message }}</span>@enderror
            @if($halaman->exists)
            <small style="color:#718096;margin-top:4px;display:block;">URL: {{ url('/halaman/' . $halaman->slug) }}</small>
            @endif
        </div>
        <div class="form-group">
            <label class="form-label">Isi Konten</label>
            <textarea name="konten" class="form-control" rows="12">{{ old('konten', $halaman->konten) }}</textarea>
            <small style="color:#718096;">Mendukung format HTML atau teks panjang.</small>
        </div>
        <div class="form-check">
            <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $halaman->aktif ?? true) ? 'checked' : '' }}>
            <label for="aktif">Tampilkan di website</label>
        </div>
        <div style="margin-top:24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
