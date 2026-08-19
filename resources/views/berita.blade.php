@extends('layouts.app')
@section('title', 'Berita')

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
        margin-bottom: 24px;
    }

    .berita-search {
        display: flex;
        gap: 10px;
        max-width: 420px;
    }
    .berita-search input {
        flex: 1;
        padding: 11px 16px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.95rem;
    }
    .berita-search button {
        background: var(--primary);
        color: var(--white);
        border: none;
        padding: 0 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .berita-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .berita-card {
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: var(--transition);
    }
    .berita-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-md);
    }
    .berita-img {
        width: 100%;
        height: 190px;
        object-fit: cover;
    }
    .berita-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-grow: 1;
    }
    .berita-tag {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--primary-light);
        text-transform: uppercase;
    }
    .berita-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.4;
    }
    .berita-excerpt {
        font-size: 0.9rem;
        color: var(--text-light);
        line-height: 1.6;
        flex-grow: 1;
    }
    .berita-read-more {
        color: var(--primary-light);
        font-weight: 600;
        font-size: 0.9rem;
    }

    @media (max-width: 992px) {
        .berita-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .berita-grid { grid-template-columns: 1fr; }
        .tk-top-section { padding: 24px; }
    }
</style>
@endpush

@section('content')

<div class="tk-container">

    <div class="tk-top-section">
        <h2 class="tk-box-title">Berita &amp; Kegiatan</h2>
        <p class="tk-top-desc">
            Kabar terbaru seputar kegiatan, kerja sama, dan capaian {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'PPKRI' }}.
        </p>
        <form action="{{ route('berita') }}" method="GET" class="berita-search">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari berita...">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="berita-grid">
        @forelse($beritas as $b)
        <a href="{{ route('berita.show', $b) }}" class="berita-card">
            @if($b->gambar)
            <img src="{{ Storage::url($b->gambar) }}" alt="{{ $b->judul }}" class="berita-img">
            @else
            <div class="berita-img" style="display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f0f4ff,#e8f0fb);color:#93c5fd;font-size:2rem;">
                <i class="fas fa-bullhorn"></i>
            </div>
            @endif
            <div class="berita-body">
                <span class="berita-tag">{{ $b->tanggal ? $b->tanggal->translatedFormat('d F Y') : '' }}</span>
                <h3 class="berita-title">{{ Str::limit($b->judul, 70) }}</h3>
                @if($b->ringkasan)
                <p class="berita-excerpt">{{ Str::limit($b->ringkasan, 90) }}</p>
                @endif
                <span class="berita-read-more">Baca Selengkapnya <i class="fas fa-arrow-right" style="font-size:0.8rem;margin-left:4px;"></i></span>
            </div>
        </a>
        @empty
        <div style="grid-column: 1 / -1; text-align:center; padding:40px 20px; color:var(--text-light);">
            <i class="fas fa-bullhorn" style="font-size:2rem;opacity:0.4;margin-bottom:12px;display:block;"></i>
            Belum ada berita.
        </div>
        @endforelse
    </div>

    @if($beritas->hasPages())
    <div style="margin-top: 32px;">
        {{ $beritas->appends(['q' => $q])->links() }}
    </div>
    @endif

</div>

@endsection
