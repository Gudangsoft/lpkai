@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('content')

<div class="admin-page-header">
    <div style="display:flex;align-items:center;gap:12px;">
        <h1 style="margin:0;"><i class="fas fa-users-cog" style="color:#7c3aed;margin-right:10px;"></i>Manajemen Pengguna</h1>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Pengguna</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:40px;">#</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="width:120px;">Role</th>
                <th style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $i => $u)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                <strong>{{ $u->name }}</strong>
                @if($u->id === auth()->id())
                <span style="background:#dbeafe;color:#1d4ed8;font-size:0.65rem;font-weight:700;padding:2px 7px;border-radius:50px;margin-left:6px;">Anda</span>
                @endif
            </td>
            <td style="color:#64748b;">{{ $u->email }}</td>
            <td>
                @if($u->role === 'admin')
                <span style="background:#dcfce7;color:#166534;font-size:0.75rem;font-weight:700;padding:3px 10px;border-radius:50px;">
                    <i class="fas fa-shield-alt" style="font-size:0.7rem;margin-right:3px;"></i>Admin
                </span>
                @else
                <span style="background:#f1f5f9;color:#475569;font-size:0.75rem;font-weight:700;padding:3px 10px;border-radius:50px;">
                    <i class="fas fa-eye" style="font-size:0.7rem;margin-right:3px;"></i>Viewer
                </span>
                @endif
            </td>
            <td>
                <div class="td-actions">
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn-icon btn-edit"><i class="fas fa-edit"></i> Edit</a>
                    @if($u->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-delete" data-confirm="Hapus pengguna ini?"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;padding:40px;color:#94a3b8;">Belum ada pengguna.</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;padding:16px 20px;background:#fef9c3;border:1px solid #fcd34d;border-radius:10px;font-size:0.875rem;color:#92400e;">
    <i class="fas fa-info-circle" style="margin-right:6px;"></i>
    <strong>Role Admin</strong> — akses penuh ke panel admin. &nbsp;|&nbsp;
    <strong>Role Viewer</strong> — setelah login langsung diarahkan ke website publik (tidak bisa masuk admin).
</div>
@endsection
