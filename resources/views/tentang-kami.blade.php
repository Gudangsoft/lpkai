@extends('layouts.app')
@section('title', 'Tentang Kami')

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

    /* ── Card Box ─────────────────────────────────────── */
    .tk-box {
        border-radius: 16px;
        background: #ffffff;
        border: 1px solid #e8edf5;
        box-shadow: 0 4px 20px rgba(13,43,94,0.08), 0 1px 4px rgba(0,0,0,0.04);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .tk-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 36px rgba(13,43,94,0.13), 0 2px 8px rgba(0,0,0,0.06);
    }

    .tk-box-header {
        background: linear-gradient(135deg, #0d2b5e 0%, #1a4a9e 100%);
        padding: 18px 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .tk-box-header-icon {
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f59e0b;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .tk-box-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        letter-spacing: 0.2px;
    }
    .tk-box-body {
        padding: 24px 28px;
        flex: 1;
        display: flex;
        align-items: center;
    }

    /* ── Top Section ──────────────────────────────────── */
    .tk-top-section {
        background: linear-gradient(135deg, #0d2b5e 0%, #1e3a8a 60%, #1a6fc4 100%);
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 36px;
        align-items: center;
        padding: 36px;
        border-radius: 16px;
        border: none;
        box-shadow: 0 8px 32px rgba(13,43,94,0.25);
    }
    .tk-top-section:hover { transform: none; box-shadow: 0 8px 32px rgba(13,43,94,0.25); }

    .tk-top-img-placeholder {
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.5);
        font-weight: 600;
        font-size: 1rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 240px;
        width: 100%;
        border: 2px dashed rgba(255,255,255,0.2);
    }

    /* ── Grid ─────────────────────────────────────────── */
    .tk-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
    }

    /* ── Lists ────────────────────────────────────────── */
    .tk-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .tk-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.93rem;
        line-height: 1.65;
        color: #374151;
    }
    .tk-list li::before {
        content: '';
        width: 8px;
        height: 8px;
        min-width: 8px;
        border-radius: 50%;
        background: #1a6fc4;
        margin-top: 7px;
    }

    .tk-misi-list {
        list-style: none;
        padding: 0;
        margin: 0;
        counter-reset: tk-counter;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .tk-misi-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.93rem;
        line-height: 1.65;
        color: #374151;
    }
    .tk-misi-list li::before {
        counter-increment: tk-counter;
        content: counter(tk-counter);
        min-width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #0d2b5e, #1a6fc4);
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1px;
        flex-shrink: 0;
    }

    /* Tags — Prinsip Lembaga (style layanan) */
    .tk-tags {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .tk-tag {
        flex: 1 1 180px;
        background: linear-gradient(135deg, #1e3a8a 0%, #1a3a8a 100%);
        color: #ffffff;
        padding: 28px 20px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 1rem;
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 14px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.15);
        position: relative;
        overflow: hidden;
        cursor: default;
    }
    .tk-tag::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        transition: all 0.6s ease;
    }
    .tk-tag:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(30, 58, 138, 0.3);
        background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
        color: #ffffff;
        border-color: rgba(255,255,255,0.2);
    }
    .tk-tag:hover::before { left: -30%; top: -30%; }
    .tk-tag i {
        font-size: 2rem;
        color: #fbbf24;
        width: 54px; height: 54px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    .tk-tag:hover i {
        background: #ffffff;
        color: #1e3a8a;
        transform: scale(1.1) rotate(5deg);
    }

    @media (max-width: 992px) {
        .tk-top-section { grid-template-columns: 1fr; }
        .tk-grid-2 { grid-template-columns: 1fr; }
    }

    /* ═══ Tim Organisasi (YCAB-style) ═══════════════════ */
    .tim-section { margin-top: 8px; }
    .tim-section-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        text-align: center;
        margin-bottom: 8px;
    }
    .tim-section-sub {
        text-align: center;
        color: var(--text-light);
        font-size: 1rem;
        margin-bottom: 56px;
    }
    .tim-group { margin-bottom: 64px; }
    .tim-group-label {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #0d2b5e, #1a6fc4);
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 8px 22px;
        border-radius: 50px;
        margin-bottom: 32px;
    }

    /* Featured leader (Ketua) */
    .tim-featured {
        display: flex;
        gap: 28px;
        align-items: flex-start;
        margin-bottom: 40px;
        cursor: pointer;
        padding: 32px;
        border-radius: 16px;
        border: 1px solid #e8edf5;
        background: #fff;
        box-shadow: 0 4px 16px rgba(13,43,94,0.07);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .tim-featured:hover {
        box-shadow: 0 14px 40px rgba(13,43,94,0.14);
        transform: translateY(-3px);
    }
    .tim-featured-photo-wrap { width: 280px; flex-shrink: 0; }
    .tim-featured-photo {
        width: 100%;
        aspect-ratio: 3/4;
        object-fit: cover;
        border-radius: 12px;
        display: block;
    }
    .tim-featured-photo-placeholder {
        width: 100%;
        aspect-ratio: 3/4;
        background: linear-gradient(135deg, #dbeafe, #e8f0fb);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        font-weight: 800;
        color: #1a6fc4;
        border-radius: 12px;
    }
    .tim-featured-info { flex: 1; padding-top: 8px; }
    .tim-featured-name {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0d2b5e;
        margin: 0 0 6px;
        line-height: 1.2;
    }
    .tim-featured-jabatan {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0 0 20px;
    }
    .tim-featured-bio {
        font-size: 0.95rem;
        line-height: 1.8;
        color: #374151;
        margin-bottom: 24px;
        text-align: justify;
        word-break: break-word;
        overflow-wrap: break-word;
        overflow: hidden;
    }
    .tim-featured-link {
        color: #1a6fc4;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: gap 0.2s;
    }
    .tim-featured:hover .tim-featured-link { gap: 12px; }

    /* Member overlay grid */
    .tim-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .tim-card {
        border-radius: 14px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        aspect-ratio: 3/4;
        background: #dbeafe;
        box-shadow: 0 4px 16px rgba(13,43,94,0.07);
    }
    .tim-card-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .tim-card:hover .tim-card-photo { transform: scale(1.05); }
    .tim-card-photo-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 800;
        color: #1a6fc4;
    }
    .tim-card-overlay {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(5,15,40,0.85) 70%);
        padding: 48px 18px 20px;
    }
    .tim-card-name {
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        margin: 0 0 5px;
        line-height: 1.3;
    }
    .tim-card-jabatan {
        font-size: 0.72rem;
        color: rgba(255,255,255,0.8);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0;
    }

    /* Modal */
    .tim-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(13,43,94,0.55);
        backdrop-filter: blur(4px);
        z-index: 9000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .tim-modal-overlay.open { display: flex; }
    .tim-modal {
        background: #fff;
        border-radius: 20px;
        max-width: 680px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 24px 60px rgba(0,0,0,0.25);
        position: relative;
        animation: modalIn 0.3s ease;
    }
    @keyframes modalIn {
        from { opacity:0; transform: scale(0.94) translateY(20px); }
        to   { opacity:1; transform: scale(1) translateY(0); }
    }
    .tim-modal-close {
        position: absolute;
        top: 16px; right: 16px;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: rgba(0,0,0,0.08);
        border: none;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        color: #334155;
        transition: background 0.2s;
        z-index: 2;
    }
    .tim-modal-close:hover { background: rgba(0,0,0,0.16); }
    .tim-modal-header {
        display: flex;
        gap: 24px;
        align-items: flex-start;
        padding: 32px 32px 24px;
        border-bottom: 1px solid #f1f5f9;
    }
    .tim-modal-photo {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 4px solid #e8f0fb;
    }
    .tim-modal-photo-placeholder {
        width: 110px; height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a6fc4, #0d2b5e);
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; font-weight: 800; color: #fff;
        flex-shrink: 0;
    }
    .tim-modal-info { flex: 1; }
    .tim-modal-kelompok {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #1a6fc4;
        background: #e8f0fb;
        padding: 3px 12px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 8px;
    }
    .tim-modal-name {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0d2b5e;
        margin: 0 0 4px;
        line-height: 1.2;
    }
    .tim-modal-jabatan {
        font-size: 0.9rem;
        color: #1a6fc4;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .tim-modal-contacts {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .tim-modal-contact-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 50px;
        text-decoration: none;
        border: 1.5px solid #e2e8f0;
        color: #334155;
        transition: all 0.2s;
    }
    .tim-modal-contact-link:hover { border-color: #1a6fc4; color: #1a6fc4; }
    .tim-modal-body { padding: 24px 32px 32px; }
    .tim-modal-bio-title {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 10px;
    }
    .tim-modal-bio-text {
        font-size: 0.95rem;
        line-height: 1.8;
        color: #374151;
        white-space: pre-line;
    }
    .tim-modal-skills {
        margin-top: 20px;
        padding: 18px 20px 18px 24px;
        background: linear-gradient(135deg, #eef4ff 0%, #e8f0fb 100%);
        border-radius: 12px;
        border-left: 4px solid #f59e0b;
        position: relative;
    }
    .tim-modal-skills-label {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #1e3a8a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .tim-modal-skills-label::before {
        content: '★';
        color: #f59e0b;
        font-size: 0.85rem;
    }
    .tim-modal-skills-text {
        font-size: 0.93rem;
        line-height: 1.85;
        color: #1e3a5f;
        text-align: justify;
        margin: 0;
        font-weight: 500;
    }

    @media (max-width: 992px) {
        .tim-featured { flex-direction: column; gap: 24px; }
        .tim-featured-photo-wrap { width: 100%; max-width: 320px; }
        .tim-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    }
    @media (max-width: 768px)  { .tim-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
    @media (max-width: 480px)  {
        .tim-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .tim-modal-header { flex-direction: column; align-items: center; text-align: center; }
        .tim-modal-contacts { justify-content: center; }
        .tim-modal-header, .tim-modal-body { padding: 20px; }
    }
</style>
@endpush

@section('content')


<div class="tk-container">

    <!-- Top Section -->
    <div class="tk-top-section">
        <div>
            @if(isset($profile) && $profile->foto_tentang_kami)
                <img src="{{ Storage::url($profile->foto_tentang_kami) }}" alt="Tentang Kami LPPSP" style="width:100%; height:240px; object-fit:cover; border-radius:12px;">
            @else
                <div class="tk-top-img-placeholder">
                    <span><i class="fas fa-building" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:0.4;"></i>Foto Tentang Kami</span>
                </div>
            @endif
        </div>
        <div>
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <div style="width:4px;height:36px;background:#f59e0b;border-radius:2px;flex-shrink:0;"></div>
                <h2 style="font-size:1.8rem;font-weight:800;color:#ffffff;margin:0;line-height:1.2;">Tentang Kami</h2>
            </div>
            <p style="color:rgba(255,255,255,0.88);line-height:1.8;font-size:1.05rem;">
                {{ isset($profile) && $profile->tentang_kami ? strip_tags($profile->tentang_kami) : 'LPPSP adalah lembaga profesional yang berkomitmen pada pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, serta penguatan tata kelola pemerintahan yang baik.' }}
            </p>
        </div>
    </div>

    <!-- Profil & Legalitas -->
    <div class="tk-grid-2">
        <div class="tk-box">
            <div class="tk-box-header">
                <div class="tk-box-header-icon"><i class="fas fa-landmark"></i></div>
                <h3 class="tk-box-title">Profil LPPSP</h3>
            </div>
            <div class="tk-box-body">
                <p style="color:#374151;line-height:1.8;font-size:0.95rem;text-align:justify;">
                    {{ isset($profile) && $profile->deskripsi_singkat ? $profile->deskripsi_singkat : 'LPPSP atau Lembaga Pengkajian dan Pengembangan Sumberdaya Pembangunan berdiri sejak tanggal 22 Mei 1998 di Semarang. Didirikan oleh sekelompok anak muda yang memiliki idealisme dan dedikasi yang diwujudkan dengan memberikan layanan kegiatan pada bidang sosial, bidang pembangunan daerah dan pemerintahan, bidang kemanusiaan, dan bidang keagamaan.' }}
                </p>
            </div>
        </div>
        <div class="tk-box">
            <div class="tk-box-header">
                <div class="tk-box-header-icon"><i class="fas fa-file-contract"></i></div>
                <h3 class="tk-box-title">Legalitas</h3>
            </div>
            <div class="tk-box-body">
                <ul class="tk-list">
                    @if(isset($profile) && $profile->legalitas)
                        @foreach(array_filter(array_map('trim', explode("\n", $profile->legalitas))) as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    @else
                        <li>Bentuk Lembaga: Lembaga Swadaya Masyarakat (LSM) / Organisasi Kemasyarakatan (Ormas)</li>
                        <li>Akta Pendirian: Nomor 11 (Sebelas), tanggal 22 Mei 1998</li>
                        <li>Akta Perubahan I: Nomor 6 (Enam), tanggal 14 Maret 2015</li>
                        <li>Akta Perubahan II: Nomor 06 (Enam), tanggal 16 Juli 2021</li>
                        <li>Pengesahan Pendirian Badan Hukum: Keputusan Kemenkumham No. AHU-0004447.AH.01.04.TAHUN 2015</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Visi & Misi -->
    <div class="tk-grid-2">
        <div class="tk-box">
            <div class="tk-box-header">
                <div class="tk-box-header-icon"><i class="fas fa-eye"></i></div>
                <h3 class="tk-box-title">Visi</h3>
            </div>
            <div class="tk-box-body">
                <p style="color:#374151;line-height:1.9;font-size:1.2rem;font-weight:500;font-style:italic;">
                    {{ isset($profile) && $profile->visi ? $profile->visi : 'Menjadi lembaga yang handal dalam pengkajian dan pengembangan sumberdaya pembangunan berlandaskan profesionalisme dan integritas.' }}
                </p>
            </div>
        </div>
        <div class="tk-box">
            <div class="tk-box-header">
                <div class="tk-box-header-icon"><i class="fas fa-list-check"></i></div>
                <h3 class="tk-box-title">Misi</h3>
            </div>
            <div class="tk-box-body">
            <ul class="tk-misi-list">
                @if(isset($profile) && $profile->misi)
                    @foreach(explode("\n", $profile->misi) as $m)
                        @if(trim($m))
                            <li>{{ trim(str_replace(['1.', '2.', '3.', '4.', '5.'], '', $m)) }}</li>
                        @endif
                    @endforeach
                @else
                    <li>Melakukan pengkajian dan penelitian untuk mendukung pelaksanaan tata kelola pemerintah daerah yang amanah dan pengelolaan lingkungan yang lestari.</li>
                    <li>Melakukan pendidikan dan pelatihan bagi peningkatan kualitas sumberdaya manusia yang semakin bermartabat.</li>
                    <li>Melakukan pengembangan dan pemberdayaan masyarakat untuk memperkuat kemandirian dan mengurangi kerentanan.</li>
                    <li>Mengembangkan advokasi untuk mendorong terwujudnya good governance.</li>
                @endif
            </ul>
            </div>
        </div>
    </div>

    <!-- Tim Organisasi (YCAB-style) -->
    @if(isset($tims) && $tims->isNotEmpty())
    <div class="tim-section">
        <h2 class="tim-section-title">Tim Organisasi</h2>

        @foreach(['Tim Pembina','Tim Pengawas','Tim Pengurus','Tim Tenaga Ahli'] as $kelompok)
        @if(isset($tims[$kelompok]) && $tims[$kelompok]->isNotEmpty())
        @php
            $iconMap  = ['Tim Pembina'=>'shield-alt','Tim Pengawas'=>'eye','Tim Pengurus'=>'star','Tim Tenaga Ahli'=>'lightbulb'];
            $labelMap = ['Tim Pembina'=>'Pembina','Tim Pengawas'=>'Pengawas','Tim Pengurus'=>'Pengurus','Tim Tenaga Ahli'=>'Tenaga Ahli'];
            $ketua    = $tims[$kelompok]->firstWhere('jabatan', 'Ketua');
            $others   = $tims[$kelompok]->reject(fn($t) => $t->jabatan === 'Ketua');
        @endphp
        <div class="tim-group">
            <div class="tim-group-label">
                <i class="fas fa-{{ $iconMap[$kelompok] ?? 'users' }}"></i>
                {{ $labelMap[$kelompok] ?? $kelompok }}
            </div>

            @if($ketua)
            <div class="tim-featured" onclick="openTimModal({{ $ketua->id }})">
                <div class="tim-featured-photo-wrap">
                    @if($ketua->foto)
                        <img src="{{ Storage::url($ketua->foto) }}" alt="{{ $ketua->nama }}" class="tim-featured-photo">
                    @else
                        <div class="tim-featured-photo-placeholder">{{ strtoupper(substr($ketua->nama,0,1)) }}</div>
                    @endif
                </div>
                <div class="tim-featured-info">
                    <h3 class="tim-featured-name">{{ $ketua->nama }}</h3>
                    <p class="tim-featured-jabatan">{{ $ketua->jabatan }}</p>
                    @if($ketua->bio)<p class="tim-featured-bio">{{ $ketua->bio }}</p>@endif
                    <span class="tim-featured-link">Lihat Profil Lengkap <i class="fas fa-arrow-right"></i></span>
                </div>
            </div>
            <div id="tim-data-{{ $ketua->id }}" style="display:none;"
                data-nama="{{ $ketua->nama }}"
                data-jabatan="{{ $ketua->jabatan }}"
                data-kelompok="{{ $ketua->kelompok }}"
                data-bio="{{ $ketua->bio }}"
                data-keahlian="{{ $ketua->keahlian }}"
                data-email="{{ $ketua->email }}"
                data-linkedin="{{ $ketua->linkedin }}"
                data-foto="{{ $ketua->foto ? Storage::url($ketua->foto) : '' }}"
                data-inisial="{{ strtoupper(substr($ketua->nama,0,1)) }}">
            </div>
            @endif

            @if($others->isNotEmpty())
            <div class="tim-grid">
                @foreach($others as $tim)
                <div class="tim-card" onclick="openTimModal({{ $tim->id }})">
                    @if($tim->foto)
                        <img src="{{ Storage::url($tim->foto) }}" alt="{{ $tim->nama }}" class="tim-card-photo">
                    @else
                        <div class="tim-card-photo-placeholder">{{ strtoupper(substr($tim->nama,0,1)) }}</div>
                    @endif
                    <div class="tim-card-overlay">
                        <h4 class="tim-card-name">{{ $tim->nama }}</h4>
                        <p class="tim-card-jabatan">{{ $tim->jabatan }}</p>
                    </div>
                </div>
                <div id="tim-data-{{ $tim->id }}" style="display:none;"
                    data-nama="{{ $tim->nama }}"
                    data-jabatan="{{ $tim->jabatan }}"
                    data-kelompok="{{ $tim->kelompok }}"
                    data-bio="{{ $tim->bio }}"
                    data-keahlian="{{ $tim->keahlian }}"
                    data-email="{{ $tim->email }}"
                    data-linkedin="{{ $tim->linkedin }}"
                    data-foto="{{ $tim->foto ? Storage::url($tim->foto) : '' }}"
                    data-inisial="{{ strtoupper(substr($tim->nama,0,1)) }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endif
        @endforeach
    </div>
    @endif

    <!-- Prinsip Lembaga -->
    <div>
        <h3 style="font-size:1.5rem;font-weight:800;color:var(--primary);margin-bottom:28px;text-align:center;">Prinsip Lembaga</h3>
        <div class="tk-tags">
            <span class="tk-tag"><i class="fas fa-briefcase"></i> Profesional</span>
            <span class="tk-tag"><i class="fas fa-shield-alt"></i> Independen</span>
            <span class="tk-tag"><i class="fas fa-check-double"></i> Berintegritas</span>
            <span class="tk-tag"><i class="fas fa-hands-helping"></i> Partisipatif</span>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div class="tim-modal-overlay" id="timModalOverlay" onclick="closeTimModal(event)">
        <div class="tim-modal" id="timModal">
            <button class="tim-modal-close" onclick="closeTimModalDirect()"><i class="fas fa-times"></i></button>
            <div class="tim-modal-header">
                <div id="modalPhoto"></div>
                <div class="tim-modal-info">
                    <span class="tim-modal-kelompok" id="modalKelompok"></span>
                    <h3 class="tim-modal-name" id="modalNama"></h3>
                    <p class="tim-modal-jabatan" id="modalJabatan"></p>
                    <div class="tim-modal-contacts" id="modalContacts"></div>
                </div>
            </div>
            <div class="tim-modal-body">
                <div id="modalBioWrap">
                    <p class="tim-modal-bio-title">Profil</p>
                    <p class="tim-modal-bio-text" id="modalBio"></p>
                </div>
                <div class="tim-modal-skills" id="modalSkills"></div>
            </div>
        </div>
    </div>



</div>

@push('scripts')
<script>
function openTimModal(id) {
    const d = document.getElementById('tim-data-' + id);
    if (!d) return;

    const nama     = d.dataset.nama;
    const jabatan  = d.dataset.jabatan;
    const kelompok = d.dataset.kelompok;
    const bio      = d.dataset.bio;
    const keahlian = d.dataset.keahlian;
    const email    = d.dataset.email;
    const linkedin = d.dataset.linkedin;
    const foto     = d.dataset.foto;
    const inisial  = d.dataset.inisial;

    // Photo
    const photoEl = document.getElementById('modalPhoto');
    photoEl.innerHTML = foto
        ? `<img src="${foto}" alt="${nama}" class="tim-modal-photo">`
        : `<div class="tim-modal-photo-placeholder">${inisial}</div>`;

    document.getElementById('modalKelompok').textContent = kelompok;
    document.getElementById('modalNama').textContent     = nama;
    document.getElementById('modalJabatan').textContent  = jabatan;

    // Contacts
    let contacts = '';
    if (email)    contacts += `<a href="mailto:${email}" class="tim-modal-contact-link"><i class="fas fa-envelope"></i> ${email}</a>`;
    if (linkedin) contacts += `<a href="${linkedin}" target="_blank" class="tim-modal-contact-link"><i class="fab fa-linkedin"></i> LinkedIn</a>`;
    document.getElementById('modalContacts').innerHTML = contacts;

    // Bio
    const bioWrap = document.getElementById('modalBioWrap');
    const bioEl   = document.getElementById('modalBio');
    if (bio) { bioEl.textContent = bio; bioWrap.style.display = 'block'; }
    else     { bioWrap.style.display = 'none'; }

    // Skills — tampilkan sebagai teks naratif rata kanan-kiri
    const skillsEl = document.getElementById('modalSkills');
    if (keahlian) {
        const items = keahlian.split(',').map(s => s.trim()).filter(Boolean);
        const narrative = items.join(', ') + (items.length ? '.' : '');
        skillsEl.innerHTML = `
            <p class="tim-modal-skills-label">Bidang Keahlian</p>
            <p class="tim-modal-skills-text">${narrative}</p>
        `;
    } else {
        skillsEl.innerHTML = '';
    }

    document.getElementById('timModalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeTimModal(e) {
    if (e.target === document.getElementById('timModalOverlay')) closeTimModalDirect();
}
function closeTimModalDirect() {
    document.getElementById('timModalOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeTimModalDirect(); });
</script>
@endpush

@endsection
