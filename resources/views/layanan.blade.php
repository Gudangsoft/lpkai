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
            background: linear-gradient(135deg, var(--primary) 0%, #1a3a8a 100%);
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

        .lu-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .lu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(30, 58, 138, 0.25);
            background: linear-gradient(135deg, #2563eb 0%, var(--primary) 100%);
        }

        .lu-card:hover::before {
            left: -30%;
            top: -30%;
        }

        .lu-icon-box {
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
            /* Gold accent */
            margin-bottom: 5px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .lu-card:hover .lu-icon-box {
            background: var(--white);
            color: var(--primary);
            transform: scale(1.1) rotate(5deg);
        }

        .lu-title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.5;
            margin: 0;
        }

        .lu-desc {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.72);
            line-height: 1.65;
            margin: 0;
            text-align: center;
        }

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
                    LPPSP menyediakan layanan pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, dan
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
                        <div class="lu-icon-box">
                            <i class="{{ $iconMap[$layanan->judul] ?? 'fas fa-check-circle' }}"></i>
                        </div>
                        <h4 class="lu-title">{{ $layanan->judul }}</h4>
                        @if($layanan->deskripsi)
                            <p class="lu-desc">{{ $layanan->deskripsi }}</p>
                        @endif
                    </div>
                @empty
                    @foreach($iconMap as $judul => $icon)
                        <div class="lu-card">
                            <div class="lu-icon-box">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <h4 class="lu-title">{{ $judul }}</h4>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>

        <!-- Keunggulan LPPSP -->
        <div class="tk-box" style="padding: 10px 0;">
            <h3 class="tk-box-title" style="text-align:center;">Keunggulan LPPSP</h3>
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