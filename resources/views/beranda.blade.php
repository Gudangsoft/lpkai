@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
<style>
    /* Professional Corporate Theme */
    :root {
        --primary-blue: #1e3a8a; /* deep modern blue */
        --primary-light: #2563eb;
        --accent-gold: #f59e0b;
        --bg-light: #f8fafc;
        --text-dark: #0f172a;
        --text-muted: #475569;
        --white: #ffffff;
        --border: #e2e8f0;
        --radius: 16px;
        --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-md: 0 10px 25px -3px rgba(0, 0, 0, 0.05), 0 4px 10px -2px rgba(0, 0, 0, 0.025);
        --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', sans-serif;
    }

    .home-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 16px 24px 40px;
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    /* Hero Section */
    .hero-section {
        display: grid;
        grid-template-columns: 1fr minmax(0, 440px);
        gap: 0;
        align-items: start;
        background: #ffffff;
        padding: 0;
        border-radius: 0;
        box-shadow: none;
        position: relative;
        overflow: hidden;
        border: none;
    }

    .hero-section::before { display: none; }

    .hero-content {
        background: #ffffff;
        border-radius: 0;
        padding: 44px 16px 44px 44px;
        position: relative;
        z-index: 1;
    }

    .hero-visual {
        position: relative;
        z-index: 1;
        width: 100%;
        overflow: hidden;
        border-radius: 0;
        display: flex;
        flex-direction: column;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(37, 99, 235, 0.1);
        color: var(--primary-light);
        font-weight: 600;
        font-size: 0.85rem;
        padding: 6px 16px;
        border-radius: 20px;
        margin-bottom: 24px;
        letter-spacing: 0.5px;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.25;
        margin-bottom: 20px;
    }

    .hero-title span {
        color: var(--primary-blue);
        position: relative;
    }

    .hero-text {
        font-size: 1.05rem;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 32px;
        text-align: justify;
    }


    /* Grid-overlay slider: semua slide di-stack, tinggi mengikuti gambar asli */
    .hero-slider {
        display: grid;
        width: 100%;
        flex: 1;
    }

    .hero-slide {
        grid-area: 1 / 1;
        width: 100%;
        height: auto;
        display: block;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        border-radius: 0;
    }

    .hero-slide.active {
        grid-area: 1 / 1;
        width: 100%;
        height: auto;
        display: block;
        opacity: 1;
        z-index: 2;
        border-radius: 0;
    }

    .slider-dots {
        position: absolute;
        bottom: 20px; left: 0; right: 0;
        display: flex; justify-content: center; gap: 8px;
        z-index: 10;
    }

    .slider-dot {
        width: 12px; height: 12px; border-radius: 50%;
        background: rgba(255,255,255,0.4); cursor: pointer;
        transition: var(--transition);
        border: 2px solid transparent;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .slider-dot.active {
        background: var(--primary-blue);
        border-color: var(--white);
        transform: scale(1.2);
    }

    /* Sambutan Ketua */
    .sambutan-section {
        background: linear-gradient(135deg, var(--primary-blue) 0%, #172554 100%);
        border-radius: var(--radius);
        padding: 36px 48px;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 28px;
        align-items: center;
        box-shadow: var(--shadow-md);
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .sambutan-section::after {
        content: '"';
        position: absolute;
        right: 40px;
        bottom: -40px;
        font-size: 250px;
        font-family: Georgia, serif;
        color: rgba(255, 255, 255, 0.05);
        line-height: 1;
    }

    .sambutan-foto-wrapper {
        position: relative;
        z-index: 1;
    }

    .sambutan-foto {
        width: 260px;
        height: 260px;
        border-radius: 50%;
        border: 6px solid rgba(255, 255, 255, 0.15);
        object-fit: cover;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .sambutan-foto-wrapper:hover .sambutan-foto {
        border-color: rgba(255, 255, 255, 0.3);
        transform: scale(1.02);
    }

    .sambutan-content {
        position: relative;
        z-index: 1;
    }

    .sambutan-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.95);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sambutan-text {
        font-size: 1.15rem;
        line-height: 1.8;
        font-weight: 300;
        color: rgba(255, 255, 255, 0.95);
        font-style: italic;
    }

    /* Logo Bar (Klien) */
    .logo-bar {
        padding: 40px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        background: var(--white);
        overflow: hidden;
    }
    .logo-track {
        display: flex;
        align-items: center;
        gap: 32px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .logo-item {
        height: 45px;
        filter: grayscale(1) opacity(0.5);
        transition: var(--transition);
    }
    .logo-item:hover {
        filter: grayscale(0) opacity(1);
    }

    /* Publikasi Cards */
    .section-header {
        text-align: center;
        margin-bottom: 28px;
    }
    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 12px;
    }
    .section-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .pub-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .pub-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
        transition: var(--transition);
    }
    .pub-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-md);
    }
    .pub-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .pub-body {
        padding: 24px;
    }
    .pub-tag {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--primary-light);
        text-transform: uppercase;
        margin-bottom: 8px;
        display: block;
    }
    .pub-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--text-dark);
        line-height: 1.4;
    }

    /* Bottom Grid (Kontak, Map) */
    .info-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 16px;
    }

    .info-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 32px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }

    .info-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
        border-color: rgba(37, 99, 235, 0.3);
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 16px;
    }

    .info-card-icon {
        width: 54px;
        height: 54px;
        background: rgba(37, 99, 235, 0.08);
        color: var(--primary-light);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        transition: var(--transition);
    }

    .info-card:hover .info-card-icon {
        background: var(--primary-light);
        color: var(--white);
    }

    .info-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .info-card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Contact specific */
    .contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-list li {
        display: flex;
        gap: 16px;
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.5;
        align-items: flex-start;
    }

    .contact-list li i {
        color: var(--primary-light);
        font-size: 1.1rem;
        margin-top: 3px;
        width: 24px;
        text-align: center;
    }

    .contact-list li strong {
        display: block;
        color: var(--text-dark);
        margin-bottom: 4px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Map specific */
    .map-container {
        width: 100%;
        flex: 1;
        min-height: 250px;
        border-radius: calc(var(--radius) - 8px);
        overflow: hidden;
        margin-top: auto;
        position: relative;
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        border: 0;
        position: absolute;
        top: 0;
        left: 0;
    }

    /* Service specific */
    .service-desc {
        color: var(--text-muted);
        font-size: 1.05rem;
        line-height: 1.7;
        margin: 0;
        text-align: justify;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: var(--primary-blue);
        color: var(--white);
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        margin-top: 24px;
        border: 1px solid transparent;
    }

    .btn-primary:hover {
        background: var(--primary-light);
        color: var(--white);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        transform: translateY(-2px);
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: transparent;
        color: var(--primary-blue);
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        margin-top: auto;
        border: 2px solid var(--primary-light);
    }

    .btn-outline:hover {
        background: rgba(37, 99, 235, 0.05);
        color: var(--primary-blue);
    }

    @media (max-width: 1024px) {
        .hero-section {
            grid-template-columns: 1fr;
            min-height: auto;
        }
        .hero-content {
            padding: 36px 28px;
            text-align: center;
        }
        .hero-title {
            font-size: 1.8rem;
        }
        .hero-visual {
            order: -1;
            min-height: 400px;
            padding: 0;
        }
        .sambutan-section {
            grid-template-columns: 1fr;
            text-align: center;
            justify-items: center;
            gap: 32px;
            padding: 40px 32px;
        }
        .sambutan-section::after {
            right: 50%;
            transform: translateX(50%);
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ═══ Layanan Beranda Section (sama dgn halaman /layanan) ═══ */
    .layanan-beranda-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }
    .layanan-beranda-card {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-blue) 0%, #1a3a8a 100%);
        color: var(--white);
        border-radius: 20px;
        padding: 30px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 18px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.15);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: default;
    }
    .layanan-beranda-card::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        transition: all 0.6s ease;
    }
    .layanan-beranda-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #fbbf24;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    .layanan-beranda-card:hover .layanan-beranda-icon {
        background: rgba(255, 255, 255, 0.15);
    }
    .layanan-beranda-title {
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.5;
        margin: 0;
        color: var(--white);
    }
    /* ── Tablet (≤992px) ─────────────────────────────── */
    @media (max-width: 992px) {
        .pub-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
    }

    /* ── Mobile Landscape / Tablet kecil (≤768px) ───── */
    @media (max-width: 768px) {
        .home-container { gap: 24px; padding: 16px 16px 32px; }

        .hero-content { padding: 32px 24px; }
        .hero-title { font-size: 1.9rem; }

        .sambutan-section { padding: 24px 20px; gap: 16px; }
        .sambutan-foto { width: 160px; height: 160px; }
        .sambutan-title { font-size: 1.2rem; }
        .sambutan-text { font-size: 1rem; }

        .section-title { font-size: 1.6rem; }

        .pub-grid { grid-template-columns: 1fr; gap: 20px; }

        .info-grid { grid-template-columns: 1fr; }

        .logo-track { gap: 32px; }
        .logo-item { height: 36px; }

        .layanan-beranda-grid { grid-template-columns: repeat(2, 1fr); }
    }

    /* ── Mobile Potrait (≤480px) ─────────────────────── */
    @media (max-width: 480px) {
        .home-container { gap: 20px; padding: 12px 12px 24px; }

        .hero-content { padding: 24px 20px; }
        .hero-title { font-size: 1.6rem; }
        .hero-text { font-size: 0.95rem; }

        .sambutan-section { grid-template-columns: 1fr; justify-items: center; text-align: center; padding: 28px 20px; }
        .sambutan-foto { width: 130px; height: 130px; }
        .sambutan-title { font-size: 1.1rem; justify-content: center; }

        .section-title { font-size: 1.4rem; }
        .section-header { margin-bottom: 32px; }

        .layanan-beranda-grid { grid-template-columns: 1fr; }
        .layanan-beranda-title { font-size: 1rem; }

        .pub-body { padding: 16px; }
        .pub-title { font-size: 1rem; }

        .logo-track { gap: 24px; }
        .logo-item { height: 30px; }

        .info-card { padding: 24px 20px; }
    }

    /* ── Sangat kecil (≤375px) ───────────────────────── */
    @media (max-width: 375px) {
        .home-container { padding: 10px 10px 24px; }
        .hero-title { font-size: 1.4rem; }
        .hero-badge { font-size: 0.75rem; padding: 5px 12px; }
        .btn-primary, .btn-outline { padding: 11px 20px; font-size: 0.85rem; }
    }
</style>
@endpush

@section('content')
<div class="home-container">
    
    <!-- Hero Section (Restored Card Style) -->
    <section class="hero-section">
        <div class="hero-content">
            @php 
                $defaultTagline = "Mitra Profesional dalam <span>Pengkajian dan Pengembangan</span> Sumberdaya Pembangunan";
                $defaultDesc = "LPPSP berkomitmen menjadi lembaga profesional yang berdedikasi tinggi dalam pemberdayaan masyarakat, pembangunan daerah, dan penguatan tata kelola pemerintahan yang baik.";
            @endphp
            @if($profile && !empty($profile->hero_badge))
            <span class="hero-badge"><i class="fas fa-chart-line"></i> {{ $profile->hero_badge }}</span>
            @endif
            <h1 class="hero-title">{!! $profile && $profile->tagline ? $profile->tagline : $defaultTagline !!}</h1>
            <p class="hero-text">
                {{ $profile && $profile->deskripsi_singkat ? $profile->deskripsi_singkat : $defaultDesc }}
            </p>
            <a href="{{ route('tentang-kami') }}" class="btn-primary">
                Pelajari Lebih Lanjut <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="hero-visual">
            @php
                $sliderImages = [];
                if($profile && !empty($profile->hero_images)) {
                    $sliderImages = is_array($profile->hero_images) ? $profile->hero_images : json_decode($profile->hero_images, true);
                } elseif ($profile && $profile->hero_image) {
                    $sliderImages = [$profile->hero_image];
                }
            @endphp

            @if(count($sliderImages) > 1)
                <div class="hero-slider">
                    @foreach($sliderImages as $index => $img)
                        <img src="{{ Storage::url($img) }}" alt="Hero Image {{ $index+1 }}" class="hero-slide {{ $index == 0 ? 'active' : '' }}">
                    @endforeach
                    <div class="slider-dots" style="grid-area: 1/1; align-self: end; z-index: 10; position: relative; padding-bottom: 12px;">
                        @foreach($sliderImages as $index => $img)
                            <span class="slider-dot {{ $index == 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></span>
                        @endforeach
                    </div>
                </div>
            @elseif(count($sliderImages) == 1)
                <img src="{{ Storage::url($sliderImages[0]) }}" alt="Hero Image" class="hero-slide active">
            @else
                <img src="https://images.unsplash.com/photo-1577415124269-fc1140a69e91?q=80&w=1200&auto=format&fit=crop" alt="Pembangunan Profesional" class="hero-slide active">
            @endif
        </div>
    </section>

    <!-- Sambutan Ketua -->
    <section class="sambutan-section">
        <div class="sambutan-foto-wrapper">
            @if($profile && $profile->foto_ketua)
                <img src="{{ Storage::url($profile->foto_ketua) }}" alt="Foto {{ $profile->sambutan_ketua_nama ?? 'Ketua LPPSP' }}" class="sambutan-foto">
            @else
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop" alt="Foto Ketua LPPSP" class="sambutan-foto">
            @endif
        </div>
        <div class="sambutan-content">
            <h2 class="sambutan-title"><i class="fas fa-quote-left" style="color: rgba(245, 232, 232, 1); font-size: 1.2rem;"></i> Sambutan {{ $profile && $profile->sambutan_ketua_nama ? $profile->sambutan_ketua_nama : 'Ketua LPPSP' }}</h2>
            <p class="sambutan-text">
                "{!! $profile && $profile->sambutan_ketua_isi ? nl2br(e($profile->sambutan_ketua_isi)) : 'Selamat datang di LPPSP. Sejak berdiri pada 22 Mei 1998 di Semarang, LPPSP berkomitmen menjadi mitra profesional dalam pengkajian dan pengembangan sumberdaya pembangunan. Kami hadir untuk memberikan kontribusi nyata melalui kerja pengkajian, pengembangan, pemberdayaan masyarakat, dan penguatan tata kelola pemerintahan secara kolaboratif dan berkelanjutan.' !!}"
            </p>
        </div>
    </section>

    {{-- ═══ LAYANAN KAMI ═══ --}}
    @if($layanans && count($layanans) > 0)
    <section class="layanan-beranda">
        <div class="section-header">
            <h2 class="section-title">Layanan Kami</h2>
        </div>
        <div class="layanan-beranda-grid">
            @php
                $iconMap = [
                    'Pengkajian dan Penelitian' => 'fas fa-microscope',
                    'Pendampingan Perencanaan Pembangunan Daerah' => 'fas fa-map-marked-alt',
                    'Evaluasi Program dan Kinerja Pembangunan' => 'fas fa-chart-line',
                    'Pengembangan Database dan Sistem Informasi' => 'fas fa-database',
                    'Pemberdayaan Masyarakat' => 'fas fa-users',
                    'Pendidikan dan Pelatihan' => 'fas fa-user-graduate',
                    'Advokasi dan Konsultasi Kebijakan Pembangunan' => 'fas fa-gavel',
                ];
            @endphp
            @foreach($layanans as $layanan)
            <div class="layanan-beranda-card">
                <div class="layanan-beranda-icon">
                    <i class="{{ $iconMap[$layanan->judul] ?? 'fas fa-check-circle' }}"></i>
                </div>
                <h3 class="layanan-beranda-title">{{ $layanan->judul }}</h3>
            </div>
            @endforeach
        </div>
        <div style="text-align: center; margin-top: 24px;">
            <a href="{{ route('layanan') }}" class="btn-primary" style="display:inline-flex;">
                <i class="fas fa-th-list"></i> Lihat Semua Layanan
            </a>
        </div>
    </section>
    @endif

    {{-- ═══ PUBLIKASI TERKINI ═══ --}}
    @if($publikasis && count($publikasis) > 0)
    <section class="publikasi-recent">
        <div class="section-header">
            <h2 class="section-title">Publikasi Terkini</h2>
        </div>
        <div class="pub-grid">
            @foreach($publikasis as $pub)
            <article class="pub-card" style="cursor:pointer;" onclick="window.location='{{ route('publikasi.show', $pub->slug) }}'">
                @if($pub->gambar)
                <img src="{{ Storage::url($pub->gambar) }}" alt="{{ $pub->judul }}" class="pub-img">
                @else
                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=600&auto=format&fit=crop" class="pub-img">
                @endif
                <div class="pub-body">
                    <span class="pub-tag">{{ $pub->kategori }}</span>
                    <h3 class="pub-title">{{ Str::limit($pub->judul, 60) }}</h3>
                    <a href="{{ route('publikasi.show', $pub->slug) }}" style="color: var(--primary-light); font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                        Baca Selengkapnya <i class="fas fa-arrow-right" style="font-size: 0.8rem; margin-left: 4px;"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('publikasi') }}" class="btn-outline">Lihat Semua Publikasi</a>
        </div>
    </section>
    @endif

    {{-- ═══ LPPSP JOURNALS ═══ --}}
    @if($journals && count($journals) > 0)
    @php
        $j = $journals->first();
        $jLink = $j->video_url ?: route('publikasi.show', $j->slug);
        $jTarget = $j->video_url ? '_blank' : '_self';
        $journalUrl = $j->video_url ?: ($profile->journals_url ?? '#');
    @endphp
    <div class="section-header">
        <h2 class="section-title">LPPSP Journals</h2>
    </div>
    <section style="background:var(--white);border-radius:var(--radius);overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-sm);">
        @if($j->gambar)
            <img src="{{ Storage::url($j->gambar) }}" alt="{{ $j->judul }}"
                style="width:100%;display:block;max-height:480px;object-fit:cover;">
        @else
            <div style="width:100%;height:360px;background:linear-gradient(135deg,#4c1d95,#7c3aed);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-book-open" style="font-size:5rem;color:rgba(255,255,255,0.35);"></i>
            </div>
        @endif
        <div style="padding:32px 40px 36px;">
            <h2 style="font-size:1.6rem;font-weight:800;color:#1e1b4b;line-height:1.3;margin:0 0 10px;">{{ $j->judul }}</h2>
            @if($j->issn)
            <p style="font-size:0.9rem;color:#6d28d9;margin:0 0 12px;font-weight:500;">
                <i class="fas fa-barcode" style="margin-right:6px;"></i>{{ $j->issn }}
            </p>
            @endif
            <p style="color:#475569;line-height:1.7;margin:0 0 24px;font-size:0.95rem;">
                @if($j->deskripsi){{ Str::limit($j->deskripsi, 220) }}
                @else Jurnal ilmiah LPPSP yang mempublikasikan hasil kajian dan penelitian di bidang kebijakan publik dan pembangunan daerah.
                @endif
            </p>
            <a href="{{ $journalUrl }}" target="{{ $jTarget }}" rel="noopener"
                style="display:inline-flex;align-items:center;gap:8px;background:#7c3aed;color:#fff;padding:12px 24px;border-radius:10px;font-weight:600;text-decoration:none;font-size:0.9rem;">
                <i class="fas fa-external-link-alt"></i> Masuk LPPSP Journals
            </a>
        </div>
    </section>
    @endif

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        if(slides.length <= 1) return;

        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            
            slides[index].classList.add('active');
            if(dots.length > 0) dots[index].classList.add('active');
            
            currentSlide = index;
        }

        window.goToSlide = function(index) {
            showSlide(index);
            resetInterval();
        };

        function nextSlide() {
            let next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 5000);
        }

        resetInterval();
    });
</script>
@endpush

@endsection
