@extends('layouts.admin')
@section('title', 'Kelola Halaman')
@section('content')
<div class="admin-page-header">
    <h1><i class="fas fa-file-lines" style="color:#1a6fc4;margin-right:10px;"></i>Kelola Halaman</h1>
    <a href="{{ route('admin.halaman.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Halaman</a>
</div>
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>#</th><th>Judul</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($halamans as $i => $h)
        <tr>
            <td>{{ $i+1 }}</td>
            <td><strong>{{ $h->judul }}</strong></td>
            <td><span class="badge {{ $h->aktif ? 'badge-aktif' : 'badge-nonaktif' }}">{{ $h->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td>
                <div class="td-actions">
                    <a href="{{ route('admin.halaman.edit', $h) }}" class="btn-icon btn-edit"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.halaman.destroy', $h) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-delete" data-confirm="Hapus halaman ini?"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;padding:32px;color:#718096;">Belum ada halaman.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top: 15px;">
        {{ $halamans->links('vendor.pagination.admin') }}
    </div>
</div>
@endsection
