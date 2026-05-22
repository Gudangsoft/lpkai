@extends('layouts.admin')
@section('title', $user->exists ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('content')

<div class="admin-page-header">
    <div style="display:flex;align-items:center;gap:12px;">
        <h1 style="margin:0;">{{ $user->exists ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h1>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="admin-form-card" style="max-width:480px;">
    <form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
        @csrf
        @if($user->exists) @method('PUT') @endif

        <div class="form-group">
            <label class="form-label">Nama <span>*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required placeholder="Nama lengkap">
            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email <span>*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}" required placeholder="email@domain.com">
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password {{ $user->exists ? '(kosongkan jika tidak diubah)' : '*' }}</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ $user->exists ? 'Isi hanya jika ingin mengubah password' : 'Minimal 8 karakter' }}"
                {{ $user->exists ? '' : 'required' }}>
            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Role <span>*</span></label>
            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="admin" {{ old('role', $user->role ?? 'admin') === 'admin' ? 'selected' : '' }}>
                    Admin — akses penuh ke panel admin
                </option>
                <option value="viewer" {{ old('role', $user->role) === 'viewer' ? 'selected' : '' }}>
                    Viewer — hanya bisa melihat website
                </option>
            </select>
            @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div style="margin-top:24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
