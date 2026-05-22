@extends('layouts.admin')
@section('title', $publikasi->exists ? 'Edit Jurnal' : 'Tambah Jurnal')
@section('content')

<div class="admin-page-header">
    <div style="display:flex;align-items:center;gap:12px;">
        <h1 style="margin:0;">{{ $publikasi->exists ? 'Edit Jurnal' : 'Tambah Jurnal' }}</h1>
        <span style="background:#ede9fe;color:#7c3aed;font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">Jurnal Ilmiah</span>
    </div>
    <a href="{{ route('admin.jurnal.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="admin-form-card" style="max-width:560px;">
    <form action="{{ $publikasi->exists ? route('admin.jurnal.update', $publikasi) : route('admin.jurnal.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if($publikasi->exists) @method('PUT') @endif
        <input type="hidden" name="kategori" value="Jurnal Ilmiah">

        <div class="form-group">
            <label class="form-label">Nama Jurnal <span>*</span></label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                value="{{ old('judul', $publikasi->judul) }}" required
                placeholder="Contoh: JARVIC — Journal of Research and Development on Public Policy">
            @error('judul')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">ISSN / Akreditasi</label>
            <input type="text" name="issn" class="form-control"
                value="{{ old('issn', $publikasi->issn) }}"
                placeholder="Contoh: P-ISSN: 2962-2611 | E-ISSN: 2962-262X | SINTA 5">
        </div>

        <div class="form-group">
            <label class="form-label">Gambar Cover Jurnal</label>
            <input type="file" name="gambar" class="form-control" accept="image/*"
                onchange="previewCover(this)">
            @if($publikasi->gambar)
            <img id="prevCover" src="{{ Storage::url($publikasi->gambar) }}"
                style="max-height:180px;margin-top:10px;border-radius:8px;border:1px solid #e2e8f0;display:block;">
            @else
            <img id="prevCover" style="display:none;max-height:180px;margin-top:10px;border-radius:8px;border:1px solid #e2e8f0;">
            @endif
        </div>

        <div class="form-check">
            <input type="checkbox" name="aktif" id="aktif" value="1"
                {{ old('aktif', $publikasi->aktif ?? true) ? 'checked' : '' }}>
            <label for="aktif">Tampilkan di website</label>
        </div>

        <div style="margin-top:24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewCover(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('prevCover');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
@endsection
