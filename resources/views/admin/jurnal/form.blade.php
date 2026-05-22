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

<div class="admin-form-card" style="max-width:860px;">
    <form action="{{ $publikasi->exists ? route('admin.jurnal.update', $publikasi) : route('admin.jurnal.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if($publikasi->exists) @method('PUT') @endif

        {{-- Kategori tersembunyi --}}
        <input type="hidden" name="kategori" value="Jurnal Ilmiah">

        <div class="form-group">
            <label class="form-label">Judul Jurnal / Artikel <span>*</span></label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                value="{{ old('judul', $publikasi->judul) }}" required
                placeholder="Contoh: Evaluasi Kebijakan Pembangunan Daerah Tertinggal...">
            @error('judul')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Penulis / Author</label>
                <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $publikasi->penulis) }}"
                    placeholder="Nama penulis atau tim penulis">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Terbit</label>
                <input type="date" name="tanggal_terbit" class="form-control"
                    value="{{ old('tanggal_terbit', $publikasi->tanggal_terbit ? $publikasi->tanggal_terbit->format('Y-m-d') : date('Y-m-d')) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Abstrak / Deskripsi Singkat</label>
            <textarea name="deskripsi" class="form-control" rows="4"
                placeholder="Abstrak atau ringkasan jurnal...">{{ old('deskripsi', $publikasi->deskripsi) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Konten Lengkap</label>
            <textarea name="konten" class="form-control" rows="8"
                placeholder="Isi lengkap artikel atau tautan ke konten...">{{ old('konten', $publikasi->konten) }}</textarea>
            <small style="color:#718096;">Mendukung format HTML.</small>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Gambar Sampul / Cover</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" data-preview="prevGambar">
                @if($publikasi->gambar)
                <img id="prevGambar" src="{{ Storage::url($publikasi->gambar) }}" class="img-preview" style="max-height:150px;margin-top:10px;">
                @else
                <img id="prevGambar" class="img-preview" style="display:none;max-height:150px;margin-top:10px;">
                @endif
            </div>
            <div class="form-group">
                <label class="form-label">File PDF / Dokumen</label>
                <input type="file" name="file_upload" class="form-control" accept=".pdf,.doc,.docx">
                @if($publikasi->file_url)
                <small style="color:#38a169;display:block;margin-top:5px;">
                    <i class="fas fa-file-pdf"></i> File diunggah —
                    <a href="{{ Storage::url($publikasi->file_url) }}" target="_blank">Lihat File</a>
                </small>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">URL Video / Presentasi (Opsional)</label>
            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $publikasi->video_url) }}"
                placeholder="https://youtube.com/...">
        </div>

        {{-- Galeri --}}
        <div class="form-group" style="margin-top:24px;border-top:1px solid var(--border);padding-top:24px;">
            <label class="form-label"><i class="fas fa-images"></i> Galeri / Lampiran Gambar</label>
            <p style="font-size:0.85rem;color:#64748b;margin-bottom:16px;">Upload beberapa gambar sekaligus. Centang untuk menghapus gambar yang ada.</p>

            @php $galeri = is_array($publikasi->galeri) ? $publikasi->galeri : []; @endphp
            @if(count($galeri) > 0)
            <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
                @foreach($galeri as $img)
                <div style="position:relative;width:120px;height:120px;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                    <img src="{{ Storage::url($img) }}" style="width:100%;height:100%;object-fit:cover;">
                    <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,0.6);padding:4px;text-align:center;">
                        <label style="color:white;font-size:12px;cursor:pointer;display:block;margin:0;">
                            <input type="checkbox" name="remove_galeri[]" value="{{ $img }}"> Hapus
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <input type="file" name="galeri[]" class="form-control" accept="image/*" multiple id="galeriInput">
            <small style="color:var(--text-muted);display:block;margin-top:6px;">Bisa memilih banyak file. Maks 4MB per gambar.</small>
            <div id="galeriPreview" style="display:flex;flex-wrap:wrap;gap:12px;margin-top:16px;"></div>
        </div>

        <div class="form-check">
            <input type="checkbox" name="unggulan" id="unggulan" value="1" {{ old('unggulan', $publikasi->unggulan) ? 'checked' : '' }}>
            <label for="unggulan">Jadikan Jurnal Unggulan</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $publikasi->aktif ?? true) ? 'checked' : '' }}>
            <label for="aktif">Tampilkan di website</label>
        </div>

        <div style="margin-top:24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Jurnal</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
const galeriInput = document.getElementById('galeriInput');
const galeriPreview = document.getElementById('galeriPreview');
if (galeriInput) {
    galeriInput.addEventListener('change', function () {
        galeriPreview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                Object.assign(img.style, { height:'100px', width:'120px', objectFit:'cover', borderRadius:'8px', border:'1px solid #cbd5e1' });
                galeriPreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
}
</script>
@endpush
@endsection
