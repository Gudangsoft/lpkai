@extends('layouts.app')
@section('title', 'Testimoni')

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
        margin-bottom: 24px;
    }

    .tk-btn {
        display: inline-block;
        background: var(--primary);
        color: var(--white);
        font-weight: 700;
        font-size: 0.95rem;
        padding: 10px 24px;
        border-radius: 50px;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .tk-btn:hover {
        background: var(--gold);
        color: var(--primary);
    }

    /* Testimoni Grid */
    .testi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 10px;
    }

    /* Card video full-width 2 kolom */
    .testi-grid.has-video {
        grid-template-columns: repeat(2, 1fr);
    }
    .testi-card-video {
        grid-column: span 1;
    }

    .testi-card {
        background: var(--white);
        border-radius: 12px;
        padding: 28px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 20px;
        transition: var(--transition);
    }
    .testi-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    /* YouTube embed */
    .testi-video-wrap {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 8px;
        background: #000;
    }
    .testi-video-wrap iframe {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        border: 0;
    }

    .testi-avatar {
        width: 52px;
        height: 52px;
        background: rgba(26, 111, 196, 0.15);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .testi-author-row {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .testi-quote {
        color: var(--text);
        font-size: 0.95rem;
        line-height: 1.7;
        flex-grow: 1;
        font-style: italic;
        border-left: 3px solid var(--accent-light);
        padding-left: 14px;
    }
    .testi-author {
        color: var(--primary);
        font-weight: 800;
        font-size: 0.9rem;
    }
    .testi-stars {
        color: #f59e0b;
        font-size: 0.8rem;
        margin-top: 2px;
    }

    @media (max-width: 992px) {
        .testi-grid, .testi-grid.has-video { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .testi-grid, .testi-grid.has-video { grid-template-columns: 1fr; }
        .tk-top-section { padding: 24px; }
    }
</style>
@endpush

@section('content')


<div class="tk-container">

    <!-- Top Section -->
    <div class="tk-top-section">
        <h2 class="tk-box-title">Testimoni Klien dan Mitra</h2>
        <p class="tk-top-desc">
            Penilaian dan pengalaman positif dari Klien dan Mitra baik Kementerian/Lembaga, Pemerintah Daerah, OPD/Instansi Teknis, Lembaga Pendidikan, Dunia Usaha, dan Lembaga mitra Pembangunan lainnya yang pernah bekerjasama dengan {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'LPPSP' }}.
        </p>
    </div>

    <!-- Testimoni Grid -->
    @php
        $hasVideo = $testimonis->contains(fn($t) => !empty($t->video_url));
        function ytEmbedUrl($url) {
            preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
            return isset($m[1]) ? 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1' : null;
        }
    @endphp
    <div class="testi-grid {{ $hasVideo ? 'has-video' : '' }}">
        @forelse($testimonis as $t)
        @php $embedUrl = $t->video_url ? ytEmbedUrl($t->video_url) : null; @endphp
        <div class="testi-card {{ $embedUrl ? 'testi-card-video' : '' }}">

            {{-- Video YouTube --}}
            @if($embedUrl)
            <div class="testi-video-wrap">
                <iframe src="{{ $embedUrl }}" title="{{ $t->nama }}"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen loading="lazy"></iframe>
            </div>
            @endif

            {{-- Author row --}}
            <div class="testi-author-row">
                <div class="testi-avatar">
                    @if($t->foto)
                        <img src="{{ Storage::url($t->foto) }}" alt="{{ $t->nama }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    @else
                        {{ strtoupper(substr($t->nama, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="testi-author">{{ $t->nama }}</div>
                    <div style="font-size:0.82rem;color:var(--text-light);margin-top:2px;">
                        {{ $t->jabatan }}{{ $t->instansi ? ', ' . $t->instansi : '' }}
                    </div>
                    @if($t->rating)
                    <div class="testi-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $t->rating ? '' : '-o' }}" style="{{ $i > $t->rating ? 'opacity:0.3' : '' }}"></i>
                        @endfor
                    </div>
                    @endif
                </div>
            </div>

            {{-- Quote --}}
            @if($t->isi)
            <div class="testi-quote">"{{ $t->isi }}"</div>
            @endif

        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align:center; padding:40px 20px; color:var(--text-light);">
            <i class="fas fa-comment-slash" style="font-size:2rem;opacity:0.4;margin-bottom:12px;display:block;"></i>
            Belum ada testimoni.
        </div>
        @endforelse
    </div>

    @if($testimonis->hasPages())
    <div style="margin-top: 32px;">
        {{ $testimonis->links() }}
    </div>
    @endif

</div>

@endsection
