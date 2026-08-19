@extends('layouts.admin')
@section('title', 'Kelola Berita')
@section('content')
<div class="admin-page-header">
    <h1><i class="fas fa-bullhorn" style="color:#1a6fc4;margin-right:10px;"></i>Kelola Berita</h1>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Berita</a>
</div>
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>#</th><th>Judul</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($beritas as $i => $b)
        <tr>
            <td>{{ $i+1 }}</td>
            <td><strong>{{ $b->judul }}</strong><br><small style="color:#718096;">Oleh: {{ $b->penulis }}</small></td>
            <td>{{ $b->tanggal ? $b->tanggal->format('d M Y') : '-' }}</td>
            <td><span class="badge {{ $b->aktif ? 'badge-aktif' : 'badge-nonaktif' }}">{{ $b->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td>
                <div class="td-actions">
                    <a href="{{ route('admin.berita.edit', $b) }}" class="btn-icon btn-edit"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.berita.destroy', $b) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-delete" data-confirm="Hapus berita ini?"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:32px;color:#718096;">Belum ada data berita.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top: 15px;">
        {{ $beritas->links('vendor.pagination.admin') }}
    </div>
</div>
@endsection
