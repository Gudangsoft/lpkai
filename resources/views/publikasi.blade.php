@extends('layouts.app')
@section('title', 'Publikasi')

@push('styles')
<style>
    .tk-container {
        max-width: 1200px;
        margin: 32px auto;
        padding: 0 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Top Section */
    .tk-top-section {
        background: var(--accent-light);
        border: 1px solid rgba(26, 111, 196, 0.2);
        border-radius: var(--radius);
        padding: 36px 40px;
    }

    .tk-box-title {
        font-size: 1.7rem;
        font-weight: 800;
        margin-bottom: 14px;
        color: var(--primary);
    }

    .tk-top-desc {
        color: var(--text);
        line-height: 1.7;
        font-size: 1.05rem;
        font-weight: 500;
        margin: 0;
    }

    /* Publikasi Grid */
    .pub-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .pub-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        display: flex;
        align-items: flex-start;
        gap: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .pub-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    .pub-logo-box {
        width: 100px;
        height: 100px;
        background: rgba(26, 111, 196, 0.15);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .pub-content {
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex-grow: 1;
    }

    .pub-card-title {
        color: var(--primary);
        font-size: 1.2rem;
        font-weight: 800;
        margin: 0;
    }

    .pub-card-desc {
        color: var(--text);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    .pub-btn {
        display: inline-block;
        background: var(--primary);
        color: var(--white);
        font-weight: 700;
        font-size: 0.9rem;
        padding: 8px 20px;
        border-radius: 50px;
        text-decoration: none;
        transition: var(--transition);
        align-self: flex-start;
        margin-top: 4px;
    }

    .pub-btn:hover {
        background: var(--gold);
        color: var(--primary);
    }

    @media (max-width: 768px) {
        .pub-grid { grid-template-columns: 1fr; }
        .tk-top-section { padding: 24px; }
        .pub-card { flex-direction: column; align-items: center; text-align: center; }
        .pub-btn { align-self: center; }
    }
</style>
@endpush

@section('content')


<div class="tk-container">

    <!-- Top Section -->
    <div class="tk-top-section">
        <h2 class="tk-box-title">Publikasi</h2>
        <p class="tk-top-desc">
            Publikasi LPPSP merupakan hasil kerjasama LPPSP dengan Klien dan Mitra dalam layanan pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, dan penguatan tata kelola pemerintahan pada bidang sosial, bidang pembangunan daerah dan pemerintahan, bidang kemanusiaan, dan bidang keagamaan.
        </p>
    </div>

    <!-- Publikasi Grid (Menu Kategori) -->
    @if($kategori === 'semua')
    <div class="pub-grid">
        <!-- Buku -->
        <div class="pub-card" style="{{ $kategori == 'Buku' ? 'border-color: var(--primary); box-shadow: 0 0 0 2px rgba(26, 111, 196, 0.2);' : '' }}">
            <div class="pub-logo-box"><i class="fas fa-book"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Buku</h3>
                <p class="pub-card-desc">Publikasi buku hasil kajian, pembelajaran, dan dokumentasi pengetahuan kelembagaan.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Buku']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>

        <!-- Artikel -->
        <div class="pub-card" style="{{ $kategori == 'Artikel' ? 'border-color: var(--primary); box-shadow: 0 0 0 2px rgba(26, 111, 196, 0.2);' : '' }}">
            <div class="pub-logo-box"><i class="fas fa-file-alt"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Artikel</h3>
                <p class="pub-card-desc">Artikel substantif mengenai isu pembangunan, tata kelola, dan pengembangan masyarakat.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Artikel']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>

        <!-- Berita Kegiatan -->
        <div class="pub-card" style="{{ $kategori == 'Berita Kegiatan' ? 'border-color: var(--primary); box-shadow: 0 0 0 2px rgba(26, 111, 196, 0.2);' : '' }}">
            <div class="pub-logo-box"><i class="fas fa-newspaper"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Berita Kegiatan</h3>
                <p class="pub-card-desc">Informasi kegiatan lembaga, pelatihan, pendampingan, dan kolaborasi LPPSP.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Berita Kegiatan']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>

        <!-- Foto/Video Kegiatan -->
        <div class="pub-card" style="{{ $kategori == 'Foto/Video Kegiatan' ? 'border-color: var(--primary); box-shadow: 0 0 0 2px rgba(26, 111, 196, 0.2);' : '' }}">
            <div class="pub-logo-box"><i class="fas fa-images"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Foto/Video Kegiatan</h3>
                <p class="pub-card-desc">Dokumentasi visual kegiatan, pelatihan, forum, dan proses pendampingan di lapangan.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Foto/Video Kegiatan']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Dynamic Post Grid -->
    @if($kategori !== 'semua')
    <div id="daftar-publikasi" style="margin-top: 28px; border-top: 1px solid var(--border); padding-top: 40px; scroll-margin-top: 80px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3 class="tk-box-title" style="margin: 0; font-size: 1.5rem;">
                Publikasi: {{ $kategori }}
            </h3>
            <a href="{{ route('publikasi') }}" style="color: var(--text-light); text-decoration: none; font-size: 0.9rem;"><i class="fas fa-times-circle"></i> Reset Filter</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
            @forelse($publikasis as $p)
            <div style="background: var(--white); border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; transition: var(--transition);">
                @if($p->gambar)
                <div style="width: 100%; height: 220px; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden; border-bottom: 1px solid var(--border);">
                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" style="width: 100%; height: 100%; object-fit: {{ $p->kategori == 'Buku' ? 'contain' : 'cover' }}; {{ $p->kategori == 'Buku' ? 'padding: 16px;' : '' }}">
                </div>
                @else
                <div style="width: 100%; height: 220px; background: rgba(26, 111, 196, 0.05); display: flex; align-items: center; justify-content: center; color: var(--primary); border-bottom: 1px solid var(--border);">
                    <i class="fas {{ $p->kategori=='Buku'?'fa-book':($p->kategori=='Artikel'?'fa-file-alt':($p->kategori=='Berita Kegiatan'?'fa-newspaper':'fa-images')) }}" style="font-size: 3rem; opacity: 0.2;"></i>
                </div>
                @endif
                <div style="padding: 24px; flex-grow: 1; display: flex; flex-direction: column;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); background: rgba(26, 111, 196, 0.1); padding: 4px 10px; border-radius: 4px; align-self: flex-start; margin-bottom: 16px;">{{ $p->kategori }}</span>
                    <h4 style="font-size: 1.15rem; color: #0d2b5e; font-weight: 800; margin: 0 0 12px; line-height: 1.4;">{{ Str::limit($p->judul, 70) }}</h4>
                    <p style="font-size: 0.95rem; color: var(--text); margin: 0 0 20px; line-height: 1.6; flex-grow: 1;">{{ Str::limit($p->deskripsi, 90) }}</p>
                    <a href="{{ route('publikasi.show', $p) }}" style="font-size: 0.9rem; font-weight: 700; color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 8px;">Baca Detail <i class="fas fa-arrow-right" style="font-size: 0.8em;"></i></a>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-light); background: #fafafa; border-radius: var(--radius); border: 1px dashed var(--border);">
                Belum ada publikasi untuk kategori ini.
            </div>
            @endforelse
        </div>

        @if($publikasis->hasPages())
        <div style="margin-top: 32px;">
            {{ $publikasis->appends(['kategori' => $kategori])->links() }}
        </div>
        @endif
    </div>
    @endif

</div>

@endsection
