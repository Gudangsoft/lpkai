@extends('layouts.admin')
@section('title', 'Kelola Tim Organisasi')
@section('content')
<div class="admin-page-header">
    <h1><i class="fas fa-users" style="color:#1a6fc4;margin-right:10px;"></i>Kelola Tim Organisasi</h1>
    <a href="{{ route('admin.tim-organisasi.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Anggota</a>
</div>

@foreach(['Tim Pengurus','Tim Pembina','Tim Pengawas','Tim Tenaga Ahli'] as $kelompok)
@php $group = $tims->where('kelompok', $kelompok); @endphp
<div style="margin-bottom:32px;">
    <h3 style="font-size:1rem;font-weight:700;color:#0d2b5e;margin-bottom:12px;padding:10px 16px;background:#e8f0fb;border-radius:8px;border-left:4px solid #1a6fc4;">
        <i class="fas fa-layer-group" style="margin-right:8px;color:#1a6fc4;"></i>{{ $kelompok }}
        <span style="font-weight:400;color:#64748b;font-size:0.85rem;"> — {{ $group->count() }} anggota</span>
    </h3>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>#</th><th>Foto</th><th>Nama & Jabatan</th><th>Bio</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($group as $i => $t)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    @if($t->foto)
                    <img src="{{ Storage::url($t->foto) }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;">
                    @else
                    <div style="width:44px;height:44px;border-radius:50%;background:#e8f0fb;display:flex;align-items:center;justify-content:center;color:#1a6fc4;font-weight:700;font-size:1.1rem;">{{ strtoupper(substr($t->nama,0,1)) }}</div>
                    @endif
                </td>
                <td>
                    <strong>{{ $t->nama }}</strong><br>
                    <small style="color:#64748b;">{{ $t->jabatan }}</small>
                    @if($t->email)<br><small style="color:#94a3b8;"><i class="fas fa-envelope"></i> {{ $t->email }}</small>@endif
                </td>
                <td style="max-width:260px;"><small style="color:#4a5568;">{{ Str::limit($t->bio, 80) }}</small></td>
                <td style="text-align:center;">{{ $t->urutan }}</td>
                <td>
                    <form action="{{ route('admin.tim-organisasi.toggle-aktif', $t) }}" method="POST" style="display:inline;">
                        @csrf @method('PATCH')
                        <label class="toggle-switch" title="{{ $t->aktif ? 'Tampil di website' : 'Tersembunyi dari website' }}">
                            <input type="checkbox" onchange="this.form.submit()" {{ $t->aktif ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </form>
                    <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ $t->aktif ? 'Tampil' : 'Tersembunyi' }}</div>
                </td>
                <td>
                    <div class="td-actions">
                        <a href="{{ route('admin.tim-organisasi.edit', $t) }}" class="btn-icon btn-edit"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.tim-organisasi.destroy', $t) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete" data-confirm="Hapus anggota ini?"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:20px;color:#a0aec0;">Belum ada anggota {{ $kelompok }}.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endforeach

@endsection
