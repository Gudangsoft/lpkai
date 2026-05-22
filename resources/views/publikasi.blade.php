@extends('layouts.app')
@section('title', 'Publikasi')

@push('styles')
<style>
    /* ── Hero ─────────────────────────────────────────── */
    .pub-hero {
        background: linear-gradient(135deg, #0d2b5e 0%, #1a4a9e 60%, #1a6fc4 100%);
        padding: 56px 0 72px;
        position: relative;
        overflow: hidden;
    }
    .pub-hero::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 340px; height: 340px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .pub-hero-inner {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 24px;
        position: relative;
        z-index: 1;
        text-align: center;
    }
    .pub-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.9);
        font-size: 0.8rem;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 20px;
        margin-bottom: 20px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: 1px solid rgba(255,255,255,0.15);
    }
    .pub-hero h1 {
        font-size: 2.4rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 16px;
        line-height: 1.2;
    }
    .pub-hero p {
        font-size: 1.05rem;
        color: rgba(255,255,255,0.8);
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
    }

    /* ── Category Nav ─────────────────────────────────── */
    .pub-nav-wrap {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        position: sticky;
        top: 0;
        z-index: 50;
    }
    .pub-nav {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        gap: 4px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .pub-nav::-webkit-scrollbar { display: none; }
    .pub-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 14px 20px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        white-space: nowrap;
        border-bottom: 3px solid transparent;
        transition: all 0.2s;
    }
    .pub-nav-link:hover { color: #1a4a9e; border-bottom-color: #c7d7f4; }
    .pub-nav-link.active { color: #1a4a9e; border-bottom-color: #1a4a9e; }
    .pub-nav-count {
        background: #e8f0fb;
        color: #1a4a9e;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 10px;
    }
    .pub-nav-link.active .pub-nav-count { background: #1a4a9e; color: #fff; }

    /* ── Main ─────────────────────────────────────────── */
    .pub-main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 60px;
    }

    /* ── Category Cards ───────────────────────────────── */
    .pub-cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }
    .pub-cat-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 28px 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        transition: all 0.25s;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .pub-cat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(13,43,94,0.12);
        border-color: #93c5fd;
    }
    .pub-cat-icon {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, #1a4a9e, #1a6fc4);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: #fff;
    }
    .pub-cat-name { font-size: 1.1rem; font-weight: 800; color: #0d2b5e; }
    .pub-cat-desc { font-size: 0.875rem; color: #64748b; line-height: 1.6; flex-grow: 1; }
    .pub-cat-cta { display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 700; color: #1a4a9e; }

    /* ── Publication Cards ───────────────────────────── */
    .pub-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e8f0fb;
    }
    .pub-section-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0d2b5e;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pub-section-title span {
        background: linear-gradient(135deg, #1a4a9e, #1a6fc4);
        color: #fff;
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 700;
    }
    .pub-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .pub-item-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        text-decoration: none;
    }
    .pub-item-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(13,43,94,0.12);
        border-color: #93c5fd;
    }
    .pub-item-img { width: 100%; height: 210px; object-fit: cover; display: block; }
    .pub-item-img-placeholder {
        width: 100%; height: 210px;
        background: linear-gradient(135deg, #f0f4ff, #e8f0fb);
        display: flex; align-items: center; justify-content: center;
        color: #93c5fd; font-size: 2.5rem;
    }
    .pub-item-body { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; gap: 10px; }
    .pub-item-tag {
        display: inline-flex; align-items: center; gap: 5px;
        background: #eff6ff; color: #1d4ed8;
        font-size: 0.7rem; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        align-self: flex-start; text-transform: uppercase; letter-spacing: 0.3px;
    }
    .pub-item-title {
        font-size: 1rem; font-weight: 700; color: #0d2b5e;
        line-height: 1.45; margin: 0;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .pub-item-desc {
        font-size: 0.85rem; color: #64748b; line-height: 1.6; margin: 0; flex-grow: 1;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .pub-item-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 20px; border-top: 1px solid #f1f5f9; font-size: 0.8rem;
    }
    .pub-item-date { color: #94a3b8; display: flex; align-items: center; gap: 5px; }
    .pub-item-read { color: #1a4a9e; font-weight: 700; display: flex; align-items: center; gap: 5px; transition: gap 0.2s; }
    .pub-item-card:hover .pub-item-read { gap: 8px; }

    .pub-empty { grid-column: 1/-1; text-align: center; padding: 60px 20px; color: #94a3b8; }
    .pub-empty i { font-size: 3rem; display: block; margin-bottom: 16px; color: #cbd5e1; }

    @media (max-width: 1024px) { .pub-cards-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) {
        .pub-hero h1 { font-size: 1.7rem; }
        .pub-cards-grid { grid-template-columns: 1fr; }
        .pub-cat-grid { grid-template-columns: 1fr 1fr; }
        .pub-section-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    }
    @media (max-width: 400px) { .pub-cat-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<div class="pub-hero">
    <div class="pub-hero-inner">
        <div class="pub-hero-badge"><i class="fas fa-newspaper"></i> Publikasi LPPSP</div>
        <h1>Publikasi &amp; Dokumentasi</h1>
        <p>Hasil kerjasama LPPSP dengan klien dan mitra dalam layanan pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, dan penguatan tata kelola pemerintahan.</p>
    </div>
</div>

@php
$iconMap = [
    'Buku'                => 'fas fa-book',
    'Artikel'             => 'fas fa-file-alt',
    'Berita Kegiatan'     => 'fas fa-newspaper',
    'Foto/Video Kegiatan' => 'fas fa-images',
    'Jurnal Ilmiah'       => 'fas fa-book-open',
];
@endphp

<div class="pub-nav-wrap">
    <nav class="pub-nav">
        <a href="{{ route('publikasi') }}" class="pub-nav-link {{ $kategori === 'semua' ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Semua
            <span class="pub-nav-count">{{ $countPerKat->sum() }}</span>
        </a>
        @foreach($kategoris as $kat)
        @if($kat->nama !== 'Jurnal Ilmiah')
        <a href="{{ route('publikasi', ['kategori' => $kat->nama]) }}#daftar-publikasi"
           class="pub-nav-link {{ $kategori === $kat->nama ? 'active' : '' }}">
            <i class="{{ $iconMap[$kat->nama] ?? 'fas fa-folder' }}"></i> {{ $kat->nama }}
            @if(isset($countPerKat[$kat->nama]))
            <span class="pub-nav-count">{{ $countPerKat[$kat->nama] }}</span>
            @endif
        </a>
        @endif
        @endforeach
    </nav>
</div>

<div class="pub-main" id="daftar-publikasi" style="scroll-margin-top:56px;">

    @if($kategori === 'semua')
    <div style="text-align:center;margin-bottom:32px;">
        <h2 style="font-size:1.5rem;font-weight:800;color:#0d2b5e;margin-bottom:8px;">Jelajahi Berdasarkan Kategori</h2>
        <p style="color:#64748b;font-size:0.95rem;">Pilih kategori untuk melihat publikasi yang tersedia</p>
    </div>
    <div class="pub-cat-grid">
        @foreach($kategoris as $kat)
        @if($kat->nama !== 'Jurnal Ilmiah')
        <a href="{{ route('publikasi', ['kategori' => $kat->nama]) }}#daftar-publikasi" class="pub-cat-card">
            <div class="pub-cat-icon"><i class="{{ $iconMap[$kat->nama] ?? 'fas fa-folder' }}"></i></div>
            <div class="pub-cat-name">{{ $kat->nama }}</div>
            <div class="pub-cat-desc">
                @switch($kat->nama)
                    @case('Buku') Publikasi buku hasil kajian, pembelajaran, dan dokumentasi pengetahuan kelembagaan. @break
                    @case('Artikel') Artikel substantif mengenai isu pembangunan, tata kelola, dan pengembangan masyarakat. @break
                    @case('Berita Kegiatan') Informasi kegiatan lembaga, pelatihan, pendampingan, dan kolaborasi LPPSP. @break
                    @case('Foto/Video Kegiatan') Dokumentasi visual kegiatan, pelatihan, forum, dan proses pendampingan. @break
                    @default Publikasi dan dokumentasi hasil kerja LPPSP.
                @endswitch
            </div>
            <div class="pub-cat-cta">
                Lihat {{ $countPerKat[$kat->nama] ?? 0 }} publikasi <i class="fas fa-arrow-right" style="font-size:0.75rem;"></i>
            </div>
        </a>
        @endif
        @endforeach
    </div>

    @else
    <div class="pub-section-header">
        <div class="pub-section-title">
            <i class="{{ $iconMap[$kategori] ?? 'fas fa-folder' }}" style="color:#1a6fc4;"></i>
            {{ $kategori }}
            <span>{{ $publikasis->total() }} publikasi</span>
        </div>
        <a href="{{ route('publikasi') }}" style="font-size:0.85rem;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:5px;">
            <i class="fas fa-times-circle"></i> Semua Kategori
        </a>
    </div>

    <div class="pub-cards-grid">
        @forelse($publikasis as $p)
        <a href="{{ route('publikasi.show', $p) }}" class="pub-item-card">
            @if($p->gambar)
                @if($p->kategori === 'Buku')
                <div style="width:100%;height:210px;background:#f8fafc;display:flex;align-items:center;justify-content:center;border-bottom:1px solid #f1f5f9;">
                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" style="max-height:195px;max-width:100%;object-fit:contain;padding:8px;">
                </div>
                @else
                <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" class="pub-item-img">
                @endif
            @else
            <div class="pub-item-img-placeholder">
                <i class="{{ $iconMap[$p->kategori] ?? 'fas fa-file' }}"></i>
            </div>
            @endif
            <div class="pub-item-body">
                <span class="pub-item-tag">
                    <i class="{{ $iconMap[$p->kategori] ?? 'fas fa-file' }}" style="font-size:0.65rem;"></i>
                    {{ $p->kategori }}
                </span>
                <h3 class="pub-item-title">{{ $p->judul }}</h3>
                @if($p->deskripsi)
                <p class="pub-item-desc">{{ $p->deskripsi }}</p>
                @endif
            </div>
            <div class="pub-item-footer">
                <span class="pub-item-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $p->tanggal_terbit ? $p->tanggal_terbit->format('d M Y') : $p->created_at->format('d M Y') }}
                </span>
                <span class="pub-item-read">Baca Detail <i class="fas fa-arrow-right" style="font-size:0.75rem;"></i></span>
            </div>
        </a>
        @empty
        <div class="pub-empty">
            <i class="fas fa-inbox"></i>
            <p style="font-size:1rem;font-weight:600;margin-bottom:6px;">Belum ada publikasi</p>
            <p style="font-size:0.875rem;">Belum ada publikasi untuk kategori ini.</p>
        </div>
        @endforelse
    </div>

    @if($publikasis->hasPages())
    <div style="margin-top:40px;display:flex;justify-content:center;">
        {{ $publikasis->appends(['kategori' => $kategori])->links() }}
    </div>
    @endif
    @endif

</div>
@endsection
