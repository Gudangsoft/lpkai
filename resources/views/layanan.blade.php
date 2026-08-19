@extends('layouts.app')
@section('title', 'Layanan Kami')

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

        .tk-box {
            border-radius: var(--radius);
            padding: 32px;
            background: transparent;
        }

        .tk-box-title {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 24px;
            color: var(--primary);
        }

        /* Top Section */
        .tk-top-section {
            background: var(--accent-light);
            border: 1px solid rgba(26, 111, 196, 0.2);
            border-radius: var(--radius);
            padding: 36px 40px;
        }

        .tk-top-img-placeholder {
            background: rgba(26, 111, 196, 0.15);
            color: var(--primary);
            font-weight: 700;
            font-size: 1.2rem;
            border-radius: calc(var(--radius) - 4px);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 160px;
            width: 100%;
            border: 2px dashed rgba(26, 111, 196, 0.3);
        }

        .tk-top-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: calc(var(--radius) - 4px);
            display: block;
        }

        /* Layanan Utama (Flex Layout for Centering) */
        .lu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            margin-top: 20px;
        }

        .lu-card {
            flex: 1 1 300px;
            max-width: 360px;
            background: var(--white);
            color: var(--text);
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            text-align: left;
            transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 6px 20px rgba(13, 43, 94, 0.08);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .lu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(30, 58, 138, 0.18);
        }

        .lu-thumb {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
        }

        .lu-thumb-placeholder {
            width: 100%;
            height: 170px;
            background: linear-gradient(135deg, var(--primary) 0%, #1a3a8a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lu-icon-box {
            width: 62px;
            height: 62px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            color: #fbbf24;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .lu-body {
            padding: 22px 24px 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-grow: 1;
        }

        .lu-title {
            font-size: 1.08rem;
            font-weight: 700;
            line-height: 1.4;
            margin: 0;
            color: var(--primary);
        }

        .lu-desc {
            font-size: 0.88rem;
            color: var(--text-light);
            line-height: 1.6;
            margin: 0;
            text-align: left;
            flex-grow: 1;
        }

        .lu-readmore {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary-light);
            font-weight: 700;
            font-size: 0.86rem;
            text-decoration: none;
            margin-top: 4px;
        }
        .lu-readmore:hover { text-decoration: underline; }

        /* Keunggulan */
        .ku-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .ku-box {
            border-radius: var(--radius);
            padding: 32px;
            background: var(--white);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .ku-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .ku-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 24px;
        }

        .ku-list li::before {
            content: '•';
            position: absolute;
            left: 0;
            top: -1px;
            color: var(--primary);
            font-size: 1.4rem;
            font-weight: bold;
            line-height: 1;
        }

        .ku-list li:last-child {
            margin-bottom: 0;
        }

        .ku-list strong {
            color: var(--primary);
            display: block;
            font-size: 1rem;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .ku-list p {
            color: var(--text-light);
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        @media (max-width: 992px) {
            .tk-top-section {
                grid-template-columns: 1fr;
            }

            .ku-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .lu-card {
                flex: 1 1 calc(50% - 24px);
            }
        }

        @media (max-width: 480px) {
            .lu-card {
                flex: 1 1 100%;
            }
        }
    </style>
@endpush

@section('content')


    <div class="tk-container">

        <!-- Top Section -->
        <div class="tk-top-section">
            <h2 class="tk-box-title" style="margin-bottom: 12px; font-size: 1.5rem;">Layanan Kami</h2>
            <p style="color: var(--text); line-height: 1.7; font-size: 1.05rem; font-weight: 500; margin:0;">
                @if(isset($profile) && $profile->deskripsi_layanan)
                    {!! nl2br(e($profile->deskripsi_layanan)) !!}
                @else
                    {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'LPPSP' }} menyediakan layanan pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, dan
                    penguatan tata kelola pemerintahan pada bidang sosial, bidang pembangunan daerah dan pemerintahan,
                    bidang kemanusiaan, dan bidang keagamaan.
                @endif
            </p>
        </div>

        <!-- Layanan Utama -->
        <div class="tk-box" style="padding: 10px 0;">
            <h3 class="tk-box-title" style="text-align: center; margin-bottom: 40px; font-size: 1.8rem;">Layanan Utama </h3>
            <div class="lu-container">
                @php
                    $iconMap = [
                        'Pengkajian dan Penelitian' => 'fas fa-microscope',
                        'Pendampingan Perencanaan Pembangunan Daerah' => 'fas fa-map-marked-alt',
                        'Evaluasi Program dan Kinerja Pembangunan' => 'fas fa-chart-line',
                        'Pengembangan Database dan Sistem Informasi' => 'fas fa-database',
                        'Pemberdayaan Masyarakat' => 'fas fa-users',
                        'Pendidikan dan Pelatihan' => 'fas fa-user-graduate',
                        'Advokasi dan Konsultasi Kebijakan Pembangunan' => 'fas fa-gavel'
                    ];
                @endphp

                @forelse($layanans as $layanan)
                    <div class="lu-card">
                        @if($layanan->gambar)
                            <img src="{{ Storage::url($layanan->gambar) }}" alt="{{ $layanan->judul }}" class="lu-thumb">
                        @else
                            <div class="lu-thumb-placeholder">
                                <div class="lu-icon-box">
                                    <i class="{{ $layanan->ikon ?: ($iconMap[$layanan->judul] ?? 'fas fa-check-circle') }}"></i>
                                </div>
                            </div>
                        @endif
                        <div class="lu-body">
                            <h4 class="lu-title">{{ $layanan->judul }}</h4>
                            @if($layanan->deskripsi)
                                <p class="lu-desc">{{ Str::limit($layanan->deskripsi, 110) }}</p>
                            @endif
                            <a href="{{ route('layanan.show', $layanan) }}" class="lu-readmore">
                                Baca Selengkapnya <i class="fas fa-arrow-right" style="font-size:0.78rem;"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    @foreach($iconMap as $judul => $icon)
                        <div class="lu-card">
                            <div class="lu-thumb-placeholder">
                                <div class="lu-icon-box">
                                    <i class="{{ $icon }}"></i>
                                </div>
                            </div>
                            <div class="lu-body">
                                <h4 class="lu-title">{{ $judul }}</h4>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>

        <!-- Keunggulan LPPSP -->
        <div class="tk-box" style="padding: 10px 0;">
            <h3 class="tk-box-title" style="text-align:center;">Keunggulan {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'LPPSP' }}</h3>
            <div class="ku-grid">
                <div class="ku-box">
                    <ul class="ku-list">
                        <li>
                            <strong>Evidence-Based Analytical Capacity</strong>
                            <p>Memiliki kapasitas pengkajian berbasis analisis yang kuat, kontekstual, dan berorientasi pada
                                kebutuhan riil di lapangan.</p>
                        </li>
                        <li>
                            <strong>Proven Experience in Development and Governance</strong>
                            <p>Berpengalaman dalam pendampingan pembangunan daerah, penguatan tata kelola pemerintahan, dan
                                pemberdayaan masyarakat.</p>
                        </li>
                    </ul>
                </div>
                <div class="ku-box">
                    <ul class="ku-list">
                        <li>
                            <strong>Integrated Service Ecosystem</strong>
                            <p>Menghadirkan layanan terintegrasi yang mencakup riset, pendampingan, pelatihan, dan advokasi
                                dalam satu kerangka yang sinergis.</p>
                        </li>
                        <li>
                            <strong>Applied and Participatory Solutions</strong>
                            <p>Menghasilkan solusi yang implementatif, partisipatif, dan relevan untuk menjawab kebutuhan
                                kelembagaan dan masyarakat.</p>
                        </li>
                        <li>
                            <strong>Commitment to Integrity and Excellence</strong>
                            <p>Menjunjung tinggi profesionalisme, integritas, dan standar mutu tinggi dalam setiap layanan.
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection