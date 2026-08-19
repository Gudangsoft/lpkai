@extends('layouts.app')
@section('title', $berita->judul)

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

    /* ── Single column ─────────────────────── */
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

    @media (max-width:600px) {
        .pd-related-grid { grid-template-columns:1fr 1fr; }
        .pd-single-img { max-height:260px; }
    }
    @media (max-width:400px) {
        .pd-related-grid { grid-template-columns:1fr; }
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="pd-breadcrumb">
    <div class="pd-breadcrumb-inner">
        <a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="pd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <a href="{{ route('berita') }}">Berita</a>
        <span class="pd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <span class="pd-breadcrumb-cur">{{ Str::limit($berita->judul, 50) }}</span>
    </div>
</div>

<section class="section">
    <div class="pd-single">
        @if($berita->gambar)
        <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" class="pd-single-img">
        @endif
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;">
            @if($berita->penulis)<span class="card-badge" style="background:#f0fff4;color:#38a169;"><i class="fas fa-user"></i> {{ $berita->penulis }}</span>@endif
            @if($berita->tanggal)<span class="card-badge" style="background:#fff3cd;color:#856404;"><i class="fas fa-calendar"></i> {{ $berita->tanggal->format('d M Y') }}</span>@endif
        </div>
        <h1 style="font-size:1.6rem;font-weight:800;color:#0d2b5e;margin-bottom:20px;line-height:1.35;">{{ $berita->judul }}</h1>
        <div style="line-height:1.9;color:#2d3748;font-size:1.05rem;">{!! nl2br(e($berita->konten ?? $berita->ringkasan)) !!}</div>
        <div style="margin-top:40px;padding-top:24px;border-top:1px solid #e2e8f0;">
            <a href="{{ route('berita') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali ke Berita</a>
        </div>
    </div>
</section>

{{-- Related --}}
@if(isset($related) && count($related) > 0)
<div class="pd-related">
    <div class="pd-related-title"><i class="fas fa-layer-group" style="color:#1a6fc4;"></i> Berita Lainnya</div>
    <div class="pd-related-grid">
        @foreach($related as $r)
        <a href="{{ route('berita.show', $r) }}" class="pd-related-card">
            @if($r->gambar)
            <img src="{{ Storage::url($r->gambar) }}" alt="{{ $r->judul }}" style="height:140px;object-fit:cover;width:100%;display:block;">
            @else
            <div style="height:140px;background:linear-gradient(135deg,#f0f4ff,#e8f0fb);display:flex;align-items:center;justify-content:center;color:#93c5fd;font-size:2rem;">
                <i class="fas fa-bullhorn"></i>
            </div>
            @endif
            <div class="pd-related-card-body">
                <div class="pd-related-card-title">{{ $r->judul }}</div>
                @if($r->tanggal)<div style="font-size:0.75rem;color:#94a3b8;margin-top:6px;"><i class="fas fa-calendar-alt"></i> {{ $r->tanggal->format('d M Y') }}</div>@endif
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection
