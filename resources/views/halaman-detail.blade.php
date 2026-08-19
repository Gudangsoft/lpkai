@extends('layouts.app')
@section('title', $halaman->judul)

@push('styles')
<style>
    .hd-breadcrumb {
        background:#f8fafc; border-bottom:1px solid var(--border); padding:14px 0;
    }
    .hd-breadcrumb-inner {
        max-width:860px; margin:0 auto; padding:0 24px;
        display:flex; align-items:center; gap:8px;
        font-size:0.85rem; color:var(--text-light); flex-wrap:wrap;
    }
    .hd-breadcrumb-inner a { color:var(--primary-light); text-decoration:none; font-weight:500; }
    .hd-breadcrumb-inner a:hover { text-decoration:underline; }
    .hd-breadcrumb-sep { color:#cbd5e1; }
    .hd-breadcrumb-cur { color:#475569; font-weight:600; }

    .hd-page { max-width:860px; margin:0 auto; padding:40px 24px 64px; }
    .hd-title { font-size:1.9rem; font-weight:800; color:var(--primary); line-height:1.3; margin-bottom:24px; }
    .hd-content { font-size:1.05rem; line-height:1.9; color:var(--text); }
    .hd-content p { margin-bottom:1.2em; }

    @media (max-width:600px) {
        .hd-title { font-size:1.4rem; }
    }
</style>
@endpush

@section('content')

<div class="hd-breadcrumb">
    <div class="hd-breadcrumb-inner">
        <a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="hd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <span class="hd-breadcrumb-cur">{{ Str::limit($halaman->judul, 60) }}</span>
    </div>
</div>

<div class="hd-page">
    <h1 class="hd-title">{{ $halaman->judul }}</h1>
    <div class="hd-content">{!! nl2br(e($halaman->konten)) !!}</div>
</div>

@endsection
