@extends('layouts.app')
@section('title', 'Publikasi')

@push('styles')
<style>
    /* ── Hero ─────────────────────────────────── */
    .pub-hero {
        background: linear-gradient(135deg, #0d2b5e 0%, #1a4a9e 60%, #1a6fc4 100%);
        padding: 40px 0 50px;
        position: relative; overflow: hidden;
    }
    .pub-hero::before {
        content:''; position:absolute; top:-80px; right:-80px;
        width:320px; height:320px; border-radius:50%;
        background:rgba(255,255,255,0.05);
    }
    .pub-hero-inner {
        max-width:1200px; margin:0 auto; padding:0 24px;
        position:relative; z-index:1;
    }
    .pub-hero h1 { font-size:2rem; font-weight:800; color:#fff; margin-bottom:8px; }
    .pub-hero p { font-size:0.95rem; color:rgba(255,255,255,0.75); margin-bottom:24px; }
    .pub-search-bar {
        display:flex; gap:0; max-width:560px;
        background:#fff; border-radius:10px;
        box-shadow:0 4px 20px rgba(0,0,0,0.15); overflow:hidden;
    }
    .pub-search-bar input {
        flex:1; padding:13px 18px; border:none; outline:none;
        font-size:0.95rem; color:#0d2b5e;
    }
    .pub-search-bar button {
        background:#f59e0b; color:#fff; border:none; padding:0 22px;
        font-weight:700; font-size:0.9rem; cursor:pointer;
        display:flex; align-items:center; gap:7px; transition:background 0.2s;
    }
    .pub-search-bar button:hover { background:#d97706; }

    /* ── Layout ─────────────────────────────────── */
    .pub-body {
        max-width:1200px; margin:32px auto 60px; padding:0 24px;
        display:grid; grid-template-columns:240px 1fr; gap:28px;
        align-items:flex-start;
    }

    /* ── Sidebar ─────────────────────────────────── */
    .pub-sidebar { display:flex; flex-direction:column; gap:16px; position:sticky; top:16px; }
    .pub-filter-card {
        background:#fff; border-radius:12px; border:1px solid #e2e8f0;
        overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.04);
    }
    .pub-filter-head {
        background:#0d2b5e; color:#fff; padding:12px 16px;
        font-size:0.8rem; font-weight:700; text-transform:uppercase;
        letter-spacing:0.5px; display:flex; align-items:center; gap:8px;
    }
    .pub-filter-list { padding:8px 0; }
    .pub-filter-item {
        display:flex; align-items:center; justify-content:space-between;
        padding:9px 16px; text-decoration:none; font-size:0.875rem;
        color:#374151; transition:background 0.15s; gap:8px;
    }
    .pub-filter-item:hover { background:#f8fafc; color:#0d2b5e; }
    .pub-filter-item.active { background:#eff6ff; color:#1a4a9e; font-weight:700; }
    .pub-filter-item i { width:16px; color:#1a6fc4; font-size:0.85rem; }
    .pub-filter-count {
        background:#e8f0fb; color:#1a4a9e; font-size:0.68rem;
        font-weight:800; padding:2px 7px; border-radius:10px; flex-shrink:0;
    }
    .pub-filter-item.active .pub-filter-count { background:#1a4a9e; color:#fff; }

    /* ── Main Content ────────────────────────────── */
    .pub-main {}
    .pub-toolbar {
        display:flex; align-items:center; justify-content:space-between;
        margin-bottom:20px; padding-bottom:16px; border-bottom:2px solid #f1f5f9;
        flex-wrap:wrap; gap:12px;
    }
    .pub-toolbar-title {
        font-size:1.1rem; font-weight:800; color:#0d2b5e;
        display:flex; align-items:center; gap:10px;
    }
    .pub-toolbar-title .badge {
        background:linear-gradient(135deg,#1a4a9e,#1a6fc4);
        color:#fff; font-size:0.7rem; padding:3px 10px;
        border-radius:20px; font-weight:700;
    }

    /* ── Category Showcase ────────────────────────── */
    .pub-cat-grid {
        display:grid; grid-template-columns:repeat(2,1fr); gap:16px;
        margin-bottom:4px;
    }
    .pub-cat-card {
        background:#fff; border-radius:14px; border:1px solid #e2e8f0;
        padding:22px 20px; display:flex; align-items:flex-start; gap:16px;
        text-decoration:none; transition:all 0.22s;
        box-shadow:0 2px 8px rgba(0,0,0,0.04);
    }
    .pub-cat-card:hover {
        transform:translateY(-4px);
        box-shadow:0 10px 28px rgba(13,43,94,0.11);
        border-color:#93c5fd;
    }
    .pub-cat-icon {
        width:48px; height:48px; border-radius:12px; flex-shrink:0;
        background:linear-gradient(135deg,#1a4a9e,#1a6fc4);
        display:flex; align-items:center; justify-content:center;
        font-size:1.2rem; color:#fff;
    }
    .pub-cat-name { font-size:1rem; font-weight:800; color:#0d2b5e; margin-bottom:4px; }
    .pub-cat-desc { font-size:0.8rem; color:#64748b; line-height:1.5; }
    .pub-cat-count { font-size:0.78rem; font-weight:700; color:#1a6fc4; margin-top:6px; }

    /* ── Publication List ─────────────────────────── */
    .pub-list { display:flex; flex-direction:column; gap:16px; }
    .pub-item {
        background:#fff; border-radius:12px; border:1px solid #e2e8f0;
        padding:16px; display:flex; gap:20px;
        transition:all 0.22s; text-decoration:none;
        box-shadow:0 2px 6px rgba(0,0,0,0.04);
    }
    .pub-item:hover {
        transform:translateY(-3px);
        box-shadow:0 10px 28px rgba(13,43,94,0.1);
        border-color:#93c5fd;
    }
    .pub-item-cover {
        width:100px; flex-shrink:0; border-radius:8px; overflow:hidden;
        border:1px solid #e2e8f0; background:#f8fafc;
        display:flex; align-items:center; justify-content:center; min-height:130px;
    }
    .pub-item-cover img { width:100%; height:130px; object-fit:cover; display:block; }
    .pub-item-cover-book img { height:130px; object-fit:contain; padding:6px; }
    .pub-item-cover-placeholder {
        width:100%; height:130px;
        background:linear-gradient(135deg,#f0f4ff,#e8f0fb);
        display:flex; align-items:center; justify-content:center;
        color:#93c5fd; font-size:1.8rem;
    }
    .pub-item-body { flex:1; display:flex; flex-direction:column; gap:8px; }
    .pub-item-tag {
        display:inline-flex; align-items:center; gap:5px;
        background:#eff6ff; color:#1d4ed8; font-size:0.68rem;
        font-weight:700; padding:3px 10px; border-radius:20px;
        align-self:flex-start; text-transform:uppercase; letter-spacing:0.3px;
    }
    .pub-item-title {
        font-size:1rem; font-weight:700; color:#0d2b5e;
        line-height:1.4; margin:0;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }
    .pub-item-desc {
        font-size:0.83rem; color:#64748b; line-height:1.6; margin:0;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }
    .pub-item-meta {
        display:flex; align-items:center; gap:16px;
        font-size:0.78rem; color:#94a3b8; margin-top:auto;
    }
    .pub-item-meta span { display:flex; align-items:center; gap:4px; }
    .pub-item-cta {
        display:inline-flex; align-items:center; gap:6px;
        background:linear-gradient(135deg,#0d2b5e,#1a6fc4);
        color:#fff; font-size:0.78rem; font-weight:700;
        padding:7px 14px; border-radius:7px;
        text-decoration:none; align-self:flex-start; margin-top:4px;
        transition:all 0.2s;
    }
    .pub-item-cta:hover { transform:translateX(3px); color:#fff; }

    .pub-empty {
        text-align:center; padding:60px 20px; color:#94a3b8;
        background:#fafafa; border-radius:12px; border:1px dashed #e2e8f0;
    }
    .pub-empty i { font-size:2.5rem; display:block; margin-bottom:12px; color:#cbd5e1; }

    @media (max-width:900px) {
        .pub-body { grid-template-columns:1fr; }
        .pub-sidebar { position:static; }
        .pub-filter-list { display:flex; flex-wrap:wrap; gap:4px; padding:10px; }
        .pub-filter-item { border-radius:8px; border:1px solid #e2e8f0; padding:6px 12px; }
    }
    @media (max-width:600px) {
        .pub-cat-grid { grid-template-columns:1fr; }
        .pub-item { flex-direction:column; }
        .pub-item-cover { width:100%; min-height:auto; }
        .pub-item-cover img { height:200px; }
    }
</style>
@endpush

@section('content')

@php
$iconMap = [
    'Buku'                => 'fas fa-book',
    'Artikel'             => 'fas fa-file-alt',
    'Berita Kegiatan'     => 'fas fa-newspaper',
    'Foto/Video Kegiatan' => 'fas fa-images',
    'Jurnal Ilmiah'       => 'fas fa-book-open',
];
$descMap = [
    'Buku'                => 'Buku hasil kajian, pembelajaran, dan dokumentasi pengetahuan kelembagaan LPPSP.',
    'Artikel'             => 'Artikel substantif mengenai isu pembangunan, tata kelola, dan pengembangan masyarakat.',
    'Berita Kegiatan'     => 'Informasi kegiatan lembaga, pelatihan, pendampingan, dan kolaborasi LPPSP.',
    'Foto/Video Kegiatan' => 'Dokumentasi visual kegiatan, pelatihan, forum, dan proses pendampingan di lapangan.',
];
@endphp

{{-- Hero + Search --}}
<div class="pub-hero">
    <div class="pub-hero-inner">
        <h1><i class="fas fa-book-open" style="margin-right:10px;opacity:0.8;"></i>Publikasi LPPSP</h1>
        <p>Temukan publikasi, artikel, buku, dan dokumentasi kegiatan hasil kerja LPPSP.</p>
        <form method="GET" action="{{ route('publikasi') }}" class="pub-search-bar">
            @if($kategori !== 'semua')<input type="hidden" name="kategori" value="{{ $kategori }}">@endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul publikasi...">
            <button type="submit"><i class="fas fa-search"></i> Cari</button>
        </form>
    </div>
</div>

<div class="pub-body">

    {{-- Sidebar Filter --}}
    <aside class="pub-sidebar">
        <div class="pub-filter-card">
            <div class="pub-filter-head"><i class="fas fa-filter"></i> Kategori</div>
            <div class="pub-filter-list">
                <a href="{{ route('publikasi') }}" class="pub-filter-item {{ $kategori === 'semua' ? 'active' : '' }}">
                    <span><i class="fas fa-th-large"></i> Semua</span>
                    <span class="pub-filter-count">{{ $countPerKat->sum() }}</span>
                </a>
                @foreach($kategoris as $kat)
                @if($kat->nama !== 'Jurnal Ilmiah')
                <a href="{{ route('publikasi', ['kategori' => $kat->nama]) }}"
                   class="pub-filter-item {{ $kategori === $kat->nama ? 'active' : '' }}">
                    <span><i class="{{ $iconMap[$kat->nama] ?? 'fas fa-folder' }}"></i> {{ $kat->nama }}</span>
                    @if(isset($countPerKat[$kat->nama]))
                    <span class="pub-filter-count">{{ $countPerKat[$kat->nama] }}</span>
                    @endif
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="pub-main" id="daftar-publikasi">

        {{-- Toolbar --}}
        <div class="pub-toolbar">
            <div class="pub-toolbar-title">
                @if($kategori === 'semua')
                <i class="fas fa-th-large" style="color:#1a6fc4;"></i> Semua Kategori
                @else
                <i class="{{ $iconMap[$kategori] ?? 'fas fa-folder' }}" style="color:#1a6fc4;"></i> {{ $kategori }}
                <span class="badge">{{ $publikasis->total() }} publikasi</span>
                @endif
            </div>
            @if($kategori !== 'semua' || request('q'))
            <a href="{{ route('publikasi') }}" style="font-size:0.82rem;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:5px;">
                <i class="fas fa-times-circle"></i> Reset
            </a>
            @endif
        </div>

        @if($kategori === 'semua' && !request('q'))
        {{-- Category Showcase --}}
        <div class="pub-cat-grid">
            @foreach($kategoris as $kat)
            @if($kat->nama !== 'Jurnal Ilmiah')
            <a href="{{ route('publikasi', ['kategori' => $kat->nama]) }}" class="pub-cat-card">
                <div class="pub-cat-icon"><i class="{{ $iconMap[$kat->nama] ?? 'fas fa-folder' }}"></i></div>
                <div>
                    <div class="pub-cat-name">{{ $kat->nama }}</div>
                    <div class="pub-cat-desc">{{ $descMap[$kat->nama] ?? '' }}</div>
                    <div class="pub-cat-count"><i class="fas fa-layer-group" style="font-size:0.7rem;"></i> {{ $countPerKat[$kat->nama] ?? 0 }} publikasi tersedia</div>
                </div>
            </a>
            @endif
            @endforeach
        </div>

        @else
        {{-- Publication List --}}
        @if($publikasis->isEmpty())
        <div class="pub-empty">
            <i class="fas fa-inbox"></i>
            <p style="font-size:1rem;font-weight:600;margin-bottom:4px;">Belum ada publikasi</p>
            <p style="font-size:0.85rem;">Coba kata kunci lain atau pilih kategori berbeda.</p>
        </div>
        @else
        <div class="pub-list">
            @foreach($publikasis as $p)
            <a href="{{ route('publikasi.show', $p) }}" class="pub-item">
                <div class="pub-item-cover {{ $p->kategori === 'Buku' ? 'pub-item-cover-book' : '' }}">
                    @if($p->gambar)
                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}">
                    @else
                    <div class="pub-item-cover-placeholder"><i class="{{ $iconMap[$p->kategori] ?? 'fas fa-file' }}"></i></div>
                    @endif
                </div>
                <div class="pub-item-body">
                    <span class="pub-item-tag"><i class="{{ $iconMap[$p->kategori] ?? 'fas fa-file' }}" style="font-size:0.65rem;"></i> {{ $p->kategori }}</span>
                    <h3 class="pub-item-title">{{ $p->judul }}</h3>
                    @if($p->deskripsi)
                    <p class="pub-item-desc">{{ $p->deskripsi }}</p>
                    @endif
                    <div class="pub-item-meta">
                        @if($p->penulis)<span><i class="fas fa-user-edit"></i> {{ Str::limit($p->penulis, 30) }}</span>@endif
                        <span><i class="fas fa-calendar-alt"></i> {{ $p->tanggal_terbit ? $p->tanggal_terbit->format('Y') : $p->created_at->format('Y') }}</span>
                        @if($p->file_url)<span><i class="fas fa-file-pdf" style="color:#ef4444;"></i> Tersedia</span>@endif
                    </div>
                    <span class="pub-item-cta">Lihat Detail <i class="fas fa-arrow-right" style="font-size:0.7rem;"></i></span>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        @if($publikasis->hasPages())
        <div style="margin-top:32px;display:flex;justify-content:center;">
            {{ $publikasis->appends(request()->only(['kategori','q']))->links() }}
        </div>
        @endif
        @endif

    </div>
</div>

@endsection
