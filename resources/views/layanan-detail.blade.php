@extends('layouts.app')
@section('title', $layanan->judul)

@push('styles')
<style>
    /* ── Breadcrumb ─────────────────────────── */
    .ld-breadcrumb {
        background:#f8fafc; border-bottom:1px solid var(--border); padding:14px 0;
    }
    .ld-breadcrumb-inner {
        max-width:900px; margin:0 auto; padding:0 24px;
        display:flex; align-items:center; gap:8px;
        font-size:0.85rem; color:var(--text-light); flex-wrap:wrap;
    }
    .ld-breadcrumb-inner a { color:var(--primary-light); text-decoration:none; font-weight:500; }
    .ld-breadcrumb-inner a:hover { text-decoration:underline; }
    .ld-breadcrumb-sep { color:#cbd5e1; }
    .ld-breadcrumb-cur { color:#475569; font-weight:600; }

    /* ── Article ────────────────────────────── */
    .ld-page { max-width:900px; margin:0 auto; padding:40px 24px 64px; }
    .ld-thumb {
        width:100%; max-height:380px; object-fit:cover;
        border-radius:16px; margin-bottom:28px; box-shadow:var(--shadow); display:block;
    }
    .ld-thumb-placeholder {
        width:100%; height:260px; border-radius:16px; margin-bottom:28px;
        background:linear-gradient(135deg, var(--primary) 0%, #1a3a8a 100%);
        display:flex; align-items:center; justify-content:center;
    }
    .ld-thumb-placeholder i { font-size:3rem; color:#fbbf24; }

    .ld-title { font-size:1.9rem; font-weight:800; color:var(--primary); line-height:1.3; margin-bottom:24px; }

    .ld-content { font-size:1.05rem; line-height:1.9; color:var(--text); }
    .ld-content p { margin-bottom:1.2em; }

    .ld-back-row {
        margin-top:40px; padding-top:24px; border-top:1px solid var(--border);
    }
    .ld-back-btn {
        display:inline-flex; align-items:center; gap:8px;
        background:var(--white); color:var(--primary); padding:11px 22px; border-radius:10px;
        font-weight:700; font-size:0.9rem; text-decoration:none;
        border:1.5px solid var(--border); transition:var(--transition);
    }
    .ld-back-btn:hover { background:var(--accent-light); border-color:var(--accent); }

    /* ── Layanan lainnya ────────────────────── */
    .ld-more { max-width:1100px; margin:0 auto 60px; padding:0 24px; }
    .ld-more-title {
        font-size:1.15rem; font-weight:800; color:var(--primary); margin-bottom:20px;
        display:flex; align-items:center; gap:10px;
    }
    .ld-more-title::after { content:''; flex:1; height:2px; background:var(--accent-light); }
    .ld-more-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .ld-more-card {
        background:var(--white); border-radius:12px; border:1px solid var(--border);
        overflow:hidden; text-decoration:none; transition:var(--transition);
        display:flex; flex-direction:column;
    }
    .ld-more-card:hover { transform:translateY(-4px); box-shadow:var(--shadow); }
    .ld-more-thumb { width:100%; height:130px; object-fit:cover; display:block; }
    .ld-more-thumb-placeholder {
        width:100%; height:130px; background:linear-gradient(135deg, var(--primary) 0%, #1a3a8a 100%);
        display:flex; align-items:center; justify-content:center; color:#fbbf24; font-size:1.6rem;
    }
    .ld-more-body { padding:14px; }
    .ld-more-card-title { font-size:0.9rem; font-weight:700; color:var(--primary); line-height:1.4; }

    @media (max-width:900px) {
        .ld-more-grid { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:600px) {
        .ld-title { font-size:1.4rem; }
        .ld-thumb, .ld-thumb-placeholder { max-height:220px; height:220px; }
        .ld-more-grid { grid-template-columns:1fr; }
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="ld-breadcrumb">
    <div class="ld-breadcrumb-inner">
        <a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="ld-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <a href="{{ route('layanan') }}">Layanan</a>
        <span class="ld-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <span class="ld-breadcrumb-cur">{{ Str::limit($layanan->judul, 60) }}</span>
    </div>
</div>

<div class="ld-page">
    @if($layanan->gambar)
    <img src="{{ Storage::url($layanan->gambar) }}" alt="{{ $layanan->judul }}" class="ld-thumb">
    @else
    <div class="ld-thumb-placeholder"><i class="{{ $layanan->ikon ?: 'fas fa-check-circle' }}"></i></div>
    @endif

    <h1 class="ld-title">{{ $layanan->judul }}</h1>

    <div class="ld-content">{!! nl2br(e($layanan->detail ?? $layanan->deskripsi)) !!}</div>

    <div class="ld-back-row">
        <a href="{{ route('layanan') }}" class="ld-back-btn"><i class="fas fa-arrow-left"></i> Kembali ke Layanan</a>
    </div>
</div>

{{-- Layanan Lainnya --}}
@if(isset($lainnya) && count($lainnya) > 0)
<div class="ld-more">
    <div class="ld-more-title"><i class="fas fa-layer-group" style="color:var(--accent);"></i> Layanan Lainnya</div>
    <div class="ld-more-grid">
        @foreach($lainnya as $l)
        <a href="{{ route('layanan.show', $l) }}" class="ld-more-card">
            @if($l->gambar)
            <img src="{{ Storage::url($l->gambar) }}" alt="{{ $l->judul }}" class="ld-more-thumb">
            @else
            <div class="ld-more-thumb-placeholder"><i class="{{ $l->ikon ?: 'fas fa-check-circle' }}"></i></div>
            @endif
            <div class="ld-more-body">
                <div class="ld-more-card-title">{{ $l->judul }}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection
