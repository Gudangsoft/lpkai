@extends('layouts.app')
@section('title', $berita->judul)

@push('styles')
<style>
    /* ── Breadcrumb ─────────────────────────── */
    .bd-breadcrumb {
        background:#f8fafc; border-bottom:1px solid var(--border); padding:14px 0;
    }
    .bd-breadcrumb-inner {
        max-width:1200px; margin:0 auto; padding:0 24px;
        display:flex; align-items:center; gap:8px;
        font-size:0.85rem; color:var(--text-light); flex-wrap:wrap;
    }
    .bd-breadcrumb-inner a { color:var(--primary-light); text-decoration:none; font-weight:500; }
    .bd-breadcrumb-inner a:hover { text-decoration:underline; }
    .bd-breadcrumb-sep { color:#cbd5e1; }
    .bd-breadcrumb-cur { color:#475569; font-weight:600; }

    /* ── Page layout ───────────────────────── */
    .bd-page { max-width:1200px; margin:0 auto; padding:40px 24px 64px; }
    .bd-layout {
        display:grid; grid-template-columns:1fr 340px; gap:48px; align-items:start;
    }

    /* ── Main article ──────────────────────── */
    .bd-badge {
        display:inline-flex; align-items:center; gap:6px;
        background:var(--accent-light); color:var(--primary-light);
        font-size:0.72rem; font-weight:800; letter-spacing:0.6px; text-transform:uppercase;
        padding:6px 14px; border-radius:20px; margin-bottom:18px;
    }
    .bd-title {
        font-size:2rem; font-weight:800; color:var(--primary);
        line-height:1.3; margin-bottom:20px;
    }
    .bd-meta {
        display:flex; flex-wrap:wrap; align-items:center; gap:18px;
        padding-bottom:20px; margin-bottom:24px; border-bottom:1px solid var(--border);
    }
    .bd-meta-item {
        display:flex; align-items:center; gap:7px;
        font-size:0.86rem; color:var(--text-light); font-weight:500;
    }
    .bd-meta-item i { color:var(--accent); }

    .bd-share { display:flex; align-items:center; gap:10px; margin-bottom:28px; }
    .bd-share-label { font-size:0.8rem; font-weight:700; color:var(--text-light); margin-right:2px; }
    .bd-share-btn {
        width:34px; height:34px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        color:#fff; font-size:0.85rem; transition:var(--transition); flex-shrink:0;
        border:none; cursor:pointer;
    }
    .bd-share-btn:hover { transform:translateY(-3px); filter:brightness(1.08); }
    .bd-share-wa { background:#25d366; }
    .bd-share-fb { background:#1877f2; }
    .bd-share-tw { background:#0d1117; }
    .bd-share-copy { background:#64748b; position:relative; }
    .bd-share-copy .bd-copied-tip {
        position:absolute; bottom:calc(100% + 8px); left:50%; transform:translateX(-50%);
        background:#1a202c; color:#fff; font-size:0.72rem; font-weight:600;
        padding:4px 10px; border-radius:6px; white-space:nowrap;
        opacity:0; pointer-events:none; transition:opacity 0.2s;
    }
    .bd-share-copy.copied .bd-copied-tip { opacity:1; }

    .bd-cover {
        width:100%; max-height:440px; object-fit:cover;
        border-radius:16px; margin-bottom:32px; box-shadow:var(--shadow);
        display:block;
    }

    .bd-content { font-size:1.08rem; line-height:1.9; color:var(--text); }
    .bd-content p { margin-bottom:1.3em; }

    .bd-footer-share {
        margin-top:40px; padding-top:24px; border-top:1px solid var(--border);
        display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px;
    }
    .bd-back-btn {
        display:inline-flex; align-items:center; gap:8px;
        background:var(--white); color:var(--primary); padding:11px 22px; border-radius:10px;
        font-weight:700; font-size:0.9rem; text-decoration:none;
        border:1.5px solid var(--border); transition:var(--transition);
    }
    .bd-back-btn:hover { background:var(--accent-light); border-color:var(--accent); }

    /* ── Sidebar ────────────────────────────── */
    .bd-sidebar { position:sticky; top:110px; display:flex; flex-direction:column; gap:24px; }
    .bd-widget {
        background:var(--white); border:1px solid var(--border); border-radius:var(--radius);
        padding:22px; box-shadow:0 2px 10px rgba(13,43,94,0.04);
    }
    .bd-widget-title {
        font-size:0.85rem; font-weight:800; color:var(--primary); text-transform:uppercase;
        letter-spacing:0.4px; margin-bottom:18px; display:flex; align-items:center; gap:8px;
    }
    .bd-widget-title i { color:var(--accent); }

    .bd-search-form { display:flex; gap:8px; }
    .bd-search-form input {
        flex:1; min-width:0; padding:10px 14px; border:1px solid var(--border); border-radius:8px;
        font-size:0.88rem;
    }
    .bd-search-form button {
        background:var(--primary); color:#fff; border:none; padding:0 16px;
        border-radius:8px; cursor:pointer; flex-shrink:0;
    }

    .bd-latest-list { display:flex; flex-direction:column; gap:16px; }
    .bd-latest-item {
        display:flex; gap:12px; text-decoration:none; align-items:flex-start;
    }
    .bd-latest-thumb {
        width:66px; height:66px; border-radius:10px; object-fit:cover; flex-shrink:0; background:var(--accent-light);
    }
    .bd-latest-thumb-ph {
        width:66px; height:66px; border-radius:10px; flex-shrink:0;
        background:linear-gradient(135deg,#eff6ff,#e8f0fb);
        display:flex; align-items:center; justify-content:center; color:#93c5fd; font-size:1.2rem;
    }
    .bd-latest-title {
        font-size:0.87rem; font-weight:700; color:var(--primary);
        line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
        margin-bottom:4px;
    }
    .bd-latest-date { font-size:0.74rem; color:var(--text-light); }
    .bd-latest-empty { font-size:0.85rem; color:var(--text-light); }

    .bd-cta {
        background:linear-gradient(135deg,var(--primary),var(--primary-light));
        color:#fff; border:none; text-align:center;
    }
    .bd-cta-title { font-size:1rem; font-weight:800; margin-bottom:8px; }
    .bd-cta-text { font-size:0.85rem; opacity:0.9; line-height:1.6; margin-bottom:18px; }
    .bd-cta-btn {
        display:inline-flex; align-items:center; justify-content:center; gap:8px;
        background:var(--gold); color:var(--primary); font-weight:800; font-size:0.87rem;
        padding:11px 20px; border-radius:10px; text-decoration:none; width:100%;
        transition:var(--transition);
    }
    .bd-cta-btn:hover { filter:brightness(1.05); transform:translateY(-2px); }

    @media (max-width:992px) {
        .bd-layout { grid-template-columns:1fr; }
        .bd-sidebar { position:static; }
    }
    @media (max-width:600px) {
        .bd-title { font-size:1.5rem; }
        .bd-cover { max-height:260px; }
        .bd-page { padding:28px 18px 48px; }
    }
</style>
@endpush

@section('content')

@php
    $wordCount   = str_word_count(strip_tags($berita->konten ?? $berita->ringkasan ?? ''));
    $readingTime = max(1, (int) ceil($wordCount / 200));
    $shareUrl    = route('berita.show', $berita);
    $shareText   = $berita->judul;
@endphp

{{-- Breadcrumb --}}
<div class="bd-breadcrumb">
    <div class="bd-breadcrumb-inner">
        <a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="bd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <a href="{{ route('berita') }}">Berita</a>
        <span class="bd-breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
        <span class="bd-breadcrumb-cur">{{ Str::limit($berita->judul, 60) }}</span>
    </div>
</div>

<div class="bd-page">
    <div class="bd-layout">

        {{-- Main article --}}
        <article class="bd-main">
            <span class="bd-badge"><i class="fas fa-bullhorn"></i> Berita</span>
            <h1 class="bd-title">{{ $berita->judul }}</h1>

            <div class="bd-meta">
                <span class="bd-meta-item"><i class="fas fa-user-edit"></i> {{ $berita->penulis ?: 'Redaksi' }}</span>
                @if($berita->tanggal)
                <span class="bd-meta-item"><i class="fas fa-calendar-alt"></i> {{ $berita->tanggal->translatedFormat('d F Y') }}</span>
                @endif
                <span class="bd-meta-item"><i class="fas fa-clock"></i> {{ $readingTime }} menit baca</span>
            </div>

            <div class="bd-share">
                <span class="bd-share-label">Bagikan:</span>
                <a class="bd-share-btn bd-share-wa" title="Bagikan ke WhatsApp" target="_blank" rel="noopener"
                   href="https://wa.me/?text={{ urlencode($shareText . ' - ' . $shareUrl) }}"><i class="fab fa-whatsapp"></i></a>
                <a class="bd-share-btn bd-share-fb" title="Bagikan ke Facebook" target="_blank" rel="noopener"
                   href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"><i class="fab fa-facebook-f"></i></a>
                <a class="bd-share-btn bd-share-tw" title="Bagikan ke X" target="_blank" rel="noopener"
                   href="https://twitter.com/intent/tweet?text={{ urlencode($shareText) }}&url={{ urlencode($shareUrl) }}"><i class="fab fa-x-twitter"></i></a>
                <button type="button" class="bd-share-btn bd-share-copy" title="Salin tautan" onclick="beritaCopyLink(this)" data-url="{{ $shareUrl }}">
                    <i class="fas fa-link"></i>
                    <span class="bd-copied-tip">Tersalin!</span>
                </button>
            </div>

            @if($berita->gambar)
            <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" class="bd-cover">
            @endif

            <div class="bd-content">{!! nl2br(e($berita->konten ?? $berita->ringkasan)) !!}</div>

            <div class="bd-footer-share">
                <a href="{{ route('berita') }}" class="bd-back-btn"><i class="fas fa-arrow-left"></i> Kembali ke Berita</a>
                <div class="bd-share" style="margin-bottom:0;">
                    <span class="bd-share-label">Bagikan:</span>
                    <a class="bd-share-btn bd-share-wa" title="Bagikan ke WhatsApp" target="_blank" rel="noopener"
                       href="https://wa.me/?text={{ urlencode($shareText . ' - ' . $shareUrl) }}"><i class="fab fa-whatsapp"></i></a>
                    <a class="bd-share-btn bd-share-fb" title="Bagikan ke Facebook" target="_blank" rel="noopener"
                       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"><i class="fab fa-facebook-f"></i></a>
                    <a class="bd-share-btn bd-share-tw" title="Bagikan ke X" target="_blank" rel="noopener"
                       href="https://twitter.com/intent/tweet?text={{ urlencode($shareText) }}&url={{ urlencode($shareUrl) }}"><i class="fab fa-x-twitter"></i></a>
                </div>
            </div>
        </article>

        {{-- Sidebar --}}
        <aside class="bd-sidebar">
            <div class="bd-widget">
                <div class="bd-widget-title"><i class="fas fa-search"></i> Cari Berita</div>
                <form action="{{ route('berita') }}" method="GET" class="bd-search-form">
                    <input type="text" name="q" placeholder="Ketik kata kunci...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="bd-widget">
                <div class="bd-widget-title"><i class="fas fa-newspaper"></i> Berita Terbaru</div>
                <div class="bd-latest-list">
                    @forelse($related as $r)
                    <a href="{{ route('berita.show', $r) }}" class="bd-latest-item">
                        @if($r->gambar)
                        <img src="{{ Storage::url($r->gambar) }}" alt="{{ $r->judul }}" class="bd-latest-thumb">
                        @else
                        <div class="bd-latest-thumb-ph"><i class="fas fa-bullhorn"></i></div>
                        @endif
                        <div>
                            <div class="bd-latest-title">{{ $r->judul }}</div>
                            <div class="bd-latest-date">{{ $r->tanggal ? $r->tanggal->translatedFormat('d F Y') : '' }}</div>
                        </div>
                    </a>
                    @empty
                    <div class="bd-latest-empty">Belum ada berita lain.</div>
                    @endforelse
                </div>
            </div>

            <div class="bd-widget bd-cta">
                <div class="bd-cta-title">{{ $profile->singkatan ?? 'PPKRI' }}</div>
                <p class="bd-cta-text">Ingin tahu lebih lanjut tentang layanan dan program kami?</p>
                <a href="{{ route('kontak') }}" class="bd-cta-btn"><i class="fas fa-paper-plane"></i> Hubungi Kami</a>
            </div>
        </aside>

    </div>
</div>

@endsection

@push('scripts')
<script>
function beritaCopyLink(btn) {
    const url = btn.getAttribute('data-url');
    const done = () => {
        btn.classList.add('copied');
        setTimeout(() => btn.classList.remove('copied'), 1500);
    };
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(done).catch(done);
    } else {
        const tmp = document.createElement('textarea');
        tmp.value = url;
        document.body.appendChild(tmp);
        tmp.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(tmp);
        done();
    }
}
</script>
@endpush
