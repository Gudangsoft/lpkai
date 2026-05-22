@extends('layouts.app')
@section('title', $publikasi->judul)

@push('styles')
<style>
    /* ── Breadcrumb ─────────────────────────── */
    .pd-breadcrumb {
        background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:12px 0;
    }
    .pd-breadcrumb-inner {
        max-width:1100px; margin:0 auto; padding:0 24px;
        display:flex; align-items:center; gap:8px;
        font-size:0.85rem; color:#64748b; flex-wrap:wrap;
    }
    .pd-breadcrumb a { color:#1a4a9e; text-decoration:none; font-weight:500; }
    .pd-breadcrumb a:hover { text-decoration:underline; }
    .pd-breadcrumb-sep { color:#cbd5e1; }
    .pd-breadcrumb-cur { color:#475569; font-weight:600; }

    /* ── BUKU: 2-column layout ──────────────── */
    .pd-container {
        max-width:1100px; margin:40px auto 60px; padding:0 24px;
        display:grid; grid-template-columns:1fr 300px; gap:40px;
        align-items:flex-start;
    }
    .pd-category-tag {
        display:inline-flex; align-items:center; gap:6px;
        background:#eff6ff; color:#1d4ed8; font-size:0.75rem; font-weight:700;
        padding:5px 14px; border-radius:20px; text-transform:uppercase;
        letter-spacing:0.4px; margin-bottom:16px;
    }
    .pd-title { font-size:1.8rem; font-weight:800; color:#0d2b5e; line-height:1.3; margin-bottom:20px; }
    .pd-meta {
        display:flex; flex-wrap:wrap; gap:12px;
        margin-bottom:28px; padding-bottom:24px; border-bottom:2px solid #f1f5f9;
    }
    .pd-meta-item {
        display:flex; align-items:center; gap:6px; font-size:0.85rem; color:#475569;
        background:#f8fafc; padding:6px 14px; border-radius:8px; border:1px solid #e2e8f0;
    }
    .pd-meta-item i { color:#1a6fc4; }
    .pd-content { font-size:1.05rem; line-height:1.85; color:#374151; }
    .pd-content p { margin-bottom:1.2em; }

    /* Sidebar (buku only) */
    .pd-sidebar { display:flex; flex-direction:column; gap:20px; position:sticky; top:20px; }
    .pd-sidebar-card {
        background:#fff; border-radius:16px; border:1px solid #e2e8f0;
        overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.06);
    }
    .pd-cover-wrap {
        background:#f8fafc; display:flex; align-items:center; justify-content:center;
        padding:20px; min-height:240px;
    }
    .pd-cover-wrap img {
        max-height:280px; max-width:100%; object-fit:contain;
        border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.15);
    }
    .pd-sidebar-body { padding:20px; display:flex; flex-direction:column; gap:12px; }
    .pd-download-btn {
        display:flex; align-items:center; justify-content:center; gap:10px;
        background:linear-gradient(135deg,#0d2b5e,#1a6fc4); color:#fff;
        padding:13px 20px; border-radius:10px; font-weight:700; font-size:0.95rem;
        text-decoration:none; transition:all 0.2s; box-shadow:0 4px 14px rgba(26,111,196,0.3);
    }
    .pd-download-btn:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(26,111,196,0.4); color:#fff; }
    .pd-back-btn {
        display:flex; align-items:center; justify-content:center; gap:8px;
        background:#f8fafc; color:#475569; padding:11px 20px; border-radius:10px;
        font-weight:600; font-size:0.875rem; text-decoration:none;
        border:1px solid #e2e8f0; transition:all 0.2s;
    }
    .pd-back-btn:hover { background:#e8f0fb; color:#1a4a9e; border-color:#c7d7f4; }
    .pd-info-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px; }
    .pd-info-list li { display:flex; align-items:flex-start; gap:10px; font-size:0.85rem; padding-bottom:10px; border-bottom:1px solid #f1f5f9; }
    .pd-info-list li:last-child { border-bottom:none; padding-bottom:0; }
    .pd-info-list li i { color:#1a6fc4; width:16px; margin-top:2px; flex-shrink:0; }
    .pd-info-label { color:#94a3b8; font-size:0.75rem; display:block; margin-bottom:2px; font-weight:600; text-transform:uppercase; letter-spacing:0.3px; }
    .pd-info-val { color:#0d2b5e; font-weight:600; }

    /* ── NON-BUKU: single column ─────────────── */
    .pd-single {
        max-width:860px; margin:40px auto 60px; padding:0 24px;
    }
    .pd-single-img {
        width:100%; border-radius:14px; margin-bottom:28px;
        box-shadow:0 4px 20px rgba(0,0,0,0.1); display:block;
        max-height:420px; object-fit:cover;
    }
    .card-badge {
        display:inline-flex; align-items:center; gap:5px;
        background:#eff6ff; color:#1d4ed8; font-size:0.78rem; font-weight:700;
        padding:5px 14px; border-radius:20px;
    }

    /* ── Gallery ─────────────────────────────── */
    .pd-gallery {
        display:grid; grid-template-columns:repeat(3,1fr); gap:10px;
        margin-top:32px; padding-top:28px; border-top:2px solid #f1f5f9;
    }
    .pd-gallery img { width:100%; height:160px; object-fit:cover; border-radius:10px; cursor:pointer; transition:transform 0.2s; }
    .pd-gallery img:hover { transform:scale(1.03); }

    /* ── Related ─────────────────────────────── */
    .pd-related { max-width:1100px; margin:0 auto 60px; padding:0 24px; }
    .pd-related-title {
        font-size:1.2rem; font-weight:800; color:#0d2b5e; margin-bottom:20px;
        display:flex; align-items:center; gap:10px;
    }
    .pd-related-title::after { content:''; flex:1; height:2px; background:#e8f0fb; }
    .pd-related-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .pd-related-card {
        background:#fff; border-radius:12px; border:1px solid #e2e8f0;
        overflow:hidden; text-decoration:none; transition:all 0.2s;
        display:flex; flex-direction:column;
    }
    .pd-related-card:hover { transform:translateY(-4px); box-shadow:0 10px 28px rgba(13,43,94,0.1); border-color:#93c5fd; }
    .pd-related-card-body { padding:14px; flex-grow:1; }
    .pd-related-card-title { font-size:0.9rem; font-weight:700; color:#0d2b5e; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

    @media (max-width:900px) {
        .pd-container { grid-template-columns:1fr; }
        .pd-sidebar { position:static; }
    }
    @media (max-width:600px) {
        .pd-gallery { grid-template-columns:repeat(2,1fr); }
        .pd-related-grid { grid-template-columns:1fr 1fr; }
        .pd-title { font-size:1.4rem; }
    }
    @media (max-width:400px) {
        .pd-related-grid { grid-template-columns:1fr; }
    }
</style>
@endpush

@section('content')

@php
$isBuku = $publikasi->kategori === 'Buku';

$videoSrc = $publikasi->video_url;
if ($videoSrc && preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $videoSrc, $m)) {
    $videoSrc = 'https://www.youtube.com/embed/' . $m[1];
} elseif ($videoSrc && preg_match('/vimeo\.com\/(\d+)/i', $videoSrc, $m)) {
    $videoSrc = 'https://player.vimeo.com/video/' . $m[1];
}
@endphp

{{-- Breadcrumb --}}
<div class="pd-breadcrumb">
    <div class="pd-breadcrumb-inner">
        <a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="pd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <a href="{{ route('publikasi') }}">Publikasi</a>
        <span class="pd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <a href="{{ route('publikasi', ['kategori' => $publikasi->kategori]) }}">{{ $publikasi->kategori }}</a>
        <span class="pd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <span class="pd-breadcrumb-cur">{{ Str::limit($publikasi->judul, 50) }}</span>
    </div>
</div>

@if($isBuku)
{{-- ══ BUKU: 2-column layout ══ --}}
<div class="pd-container">
    <div class="pd-main">
        <span class="pd-category-tag"><i class="fas fa-book"></i> {{ $publikasi->kategori }}</span>
        <h1 class="pd-title">{{ $publikasi->judul }}</h1>
        <div class="pd-meta">
            @if($publikasi->penulis)<div class="pd-meta-item"><i class="fas fa-user-edit"></i> {{ $publikasi->penulis }}</div>@endif
            @if($publikasi->tanggal_terbit)<div class="pd-meta-item"><i class="fas fa-calendar-alt"></i> {{ $publikasi->tanggal_terbit->translatedFormat('d F Y') }}</div>@endif
            @if($publikasi->issn)<div class="pd-meta-item"><i class="fas fa-barcode"></i> {{ $publikasi->issn }}</div>@endif
        </div>
        @if($videoSrc)
        <div style="margin-bottom:28px;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);position:relative;padding-top:56.25%;">
            <iframe src="{{ $videoSrc }}" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
        </div>
        @endif
        <div class="pd-content">{!! nl2br(e($publikasi->konten ?? $publikasi->deskripsi)) !!}</div>
        @if($publikasi->galeri && count($publikasi->galeri) > 0)
        <div class="pd-gallery">
            @foreach($publikasi->galeri as $img)
            <img src="{{ Storage::url($img) }}" alt="Galeri" onclick="window.open('{{ Storage::url($img) }}','_blank')">
            @endforeach
        </div>
        @endif
    </div>
    <div class="pd-sidebar">
        <div class="pd-sidebar-card">
            @if($publikasi->gambar)
            <div class="pd-cover-wrap"><img src="{{ Storage::url($publikasi->gambar) }}" alt="{{ $publikasi->judul }}"></div>
            @endif
            <div class="pd-sidebar-body">
                @if($publikasi->file_url)
                <a href="{{ Storage::url($publikasi->file_url) }}" download class="pd-download-btn"><i class="fas fa-download"></i> Unduh Dokumen</a>
                @endif
                <a href="{{ route('publikasi', ['kategori' => $publikasi->kategori]) }}" class="pd-back-btn"><i class="fas fa-arrow-left"></i> Kembali ke Buku</a>
            </div>
        </div>
        <div class="pd-sidebar-card">
            <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                <h4 style="font-size:0.82rem;font-weight:800;color:#0d2b5e;margin:0;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-info-circle" style="color:#1a6fc4;"></i> Informasi Publikasi
                </h4>
            </div>
            <div style="padding:16px 18px;">
                <ul class="pd-info-list">
                    <li><i class="fas fa-tag"></i><div><span class="pd-info-label">Kategori</span><span class="pd-info-val">{{ $publikasi->kategori }}</span></div></li>
                    @if($publikasi->penulis)<li><i class="fas fa-user-edit"></i><div><span class="pd-info-label">Penulis / Tim</span><span class="pd-info-val">{{ $publikasi->penulis }}</span></div></li>@endif
                    @if($publikasi->tanggal_terbit)<li><i class="fas fa-calendar-alt"></i><div><span class="pd-info-label">Tanggal Terbit</span><span class="pd-info-val">{{ $publikasi->tanggal_terbit->translatedFormat('d F Y') }}</span></div></li>@endif
                    @if($publikasi->issn)<li><i class="fas fa-barcode"></i><div><span class="pd-info-label">ISSN</span><span class="pd-info-val">{{ $publikasi->issn }}</span></div></li>@endif
                    @if($publikasi->file_url)<li><i class="fas fa-file-pdf"></i><div><span class="pd-info-label">File</span><span class="pd-info-val">Tersedia untuk diunduh</span></div></li>@endif
                </ul>
            </div>
        </div>
    </div>
</div>

@else
{{-- ══ NON-BUKU: single column (original style) ══ --}}
<section class="section">
    <div class="pd-single">
        @if($publikasi->gambar)
        <img src="{{ Storage::url($publikasi->gambar) }}" alt="{{ $publikasi->judul }}" class="pd-single-img">
        @endif
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;">
            <span class="card-badge">{{ $publikasi->kategori }}</span>
            @if($publikasi->penulis)<span class="card-badge" style="background:#f0fff4;color:#38a169;"><i class="fas fa-user"></i> {{ $publikasi->penulis }}</span>@endif
            @if($publikasi->tanggal_terbit)<span class="card-badge" style="background:#fff3cd;color:#856404;"><i class="fas fa-calendar"></i> {{ $publikasi->tanggal_terbit->format('d M Y') }}</span>@endif
        </div>
        <h1 style="font-size:1.6rem;font-weight:800;color:#0d2b5e;margin-bottom:20px;line-height:1.35;">{{ $publikasi->judul }}</h1>
        @if($videoSrc)
        <div style="margin-bottom:28px;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);position:relative;padding-top:56.25%;">
            <iframe src="{{ $videoSrc }}" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
        </div>
        @endif
        <div style="line-height:1.9;color:#2d3748;font-size:1.05rem;">{!! nl2br(e($publikasi->konten ?? $publikasi->deskripsi)) !!}</div>
        @if($publikasi->galeri && count($publikasi->galeri) > 0)
        <div class="pd-gallery">
            @foreach($publikasi->galeri as $img)
            <img src="{{ Storage::url($img) }}" alt="Galeri" onclick="window.open('{{ Storage::url($img) }}','_blank')">
            @endforeach
        </div>
        @endif
        @if($publikasi->file_url)
        <div style="margin-top:32px;">
            <a href="{{ Storage::url($publikasi->file_url) }}" download class="btn btn-primary"><i class="fas fa-download"></i> Unduh File</a>
        </div>
        @endif
        <div style="margin-top:40px;padding-top:24px;border-top:1px solid #e2e8f0;">
            <a href="{{ route('publikasi', ['kategori' => $publikasi->kategori]) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali ke {{ $publikasi->kategori }}</a>
        </div>
    </div>
</section>
@endif

{{-- Related --}}
@if(isset($related) && count($related) > 0)
<div class="pd-related">
    <div class="pd-related-title"><i class="fas fa-layer-group" style="color:#1a6fc4;"></i> Publikasi Lainnya</div>
    <div class="pd-related-grid">
        @foreach($related as $r)
        <a href="{{ route('publikasi.show', $r) }}" class="pd-related-card">
            @if($r->gambar)
            <img src="{{ Storage::url($r->gambar) }}" alt="{{ $r->judul }}"
                style="{{ $r->kategori==='Buku' ? 'height:140px;object-fit:contain;background:#f8fafc;padding:8px;width:100%;display:block;' : 'height:140px;object-fit:cover;width:100%;display:block;' }}">
            @else
            <div style="height:140px;background:linear-gradient(135deg,#f0f4ff,#e8f0fb);display:flex;align-items:center;justify-content:center;color:#93c5fd;font-size:2rem;">
                <i class="fas fa-file-alt"></i>
            </div>
            @endif
            <div class="pd-related-card-body">
                <div class="pd-related-card-title">{{ $r->judul }}</div>
                @if($r->tanggal_terbit)<div style="font-size:0.75rem;color:#94a3b8;margin-top:6px;"><i class="fas fa-calendar-alt"></i> {{ $r->tanggal_terbit->format('d M Y') }}</div>@endif
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection
