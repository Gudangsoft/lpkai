@extends('layouts.admin')
@section('title', 'Kategori Publikasi')
@section('content')

<div class="admin-page-header">
    <h1><i class="fas fa-tags"></i> Kategori Publikasi</h1>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1.5fr;gap:24px;align-items:start;">

    {{-- Form Tambah --}}
    <div class="admin-form-card">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px;color:var(--primary);">Tambah Kategori Baru</h3>
        <form action="{{ route('admin.kategori-publikasi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kategori <span>*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" placeholder="Contoh: Jurnal Ilmiah" required>
                @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}" min="0">
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</button>
        </form>
    </div>

    {{-- Daftar Kategori --}}
    <div class="admin-form-card" style="padding:0;overflow:hidden;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th style="text-align:center;width:70px;">Urutan</th>
                    <th style="text-align:center;width:80px;">Status</th>
                    <th style="text-align:center;width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kat)
                <tr>
                    <td><strong>{{ $kat->nama }}</strong></td>
                    <td style="text-align:center;">{{ $kat->urutan }}</td>
                    <td style="text-align:center;">
                        <span class="badge {{ $kat->aktif ? 'badge-success' : 'badge-secondary' }}">
                            {{ $kat->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <button class="btn btn-sm btn-outline" onclick="openEdit({{ $kat->id }}, '{{ addslashes($kat->nama) }}', {{ $kat->urutan }}, {{ $kat->aktif ? 1 : 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.kategori-publikasi.destroy', $kat) }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:32px;">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Modal Edit --}}
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:28px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <h3 style="margin:0 0 20px;font-size:1.1rem;color:var(--primary);">Edit Kategori</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Kategori <span>*</span></label>
                <input type="text" name="nama" id="editNama" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Urutan</label>
                <input type="number" name="urutan" id="editUrutan" class="form-control" min="0">
            </div>
            <div class="form-check">
                <input type="checkbox" name="aktif" id="editAktif" value="1">
                <label for="editAktif">Aktif</label>
            </div>
            <div style="display:flex;gap:10px;margin-top:20px;">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-outline" onclick="closeEdit()">Batal</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEdit(id, nama, urutan, aktif) {
    document.getElementById('editForm').action = '/admin/kategori-publikasi/' + id;
    document.getElementById('editNama').value   = nama;
    document.getElementById('editUrutan').value = urutan;
    document.getElementById('editAktif').checked = aktif == 1;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEdit() {
    document.getElementById('editModal').style.display = 'none';
}
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
});
</script>
@endpush
@endsection
