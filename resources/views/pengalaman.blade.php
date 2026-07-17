@extends('layouts.app')
@section('title', 'Pengalaman')

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

    /* Layanan Cards */
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
        gap: 14px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.15);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
    }
    .lu-card::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        transition: all 0.6s ease;
    }
    .lu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(30, 58, 138, 0.25);
        background: linear-gradient(135deg, #2563eb 0%, var(--primary) 100%);
    }
    .lu-card:hover::before { left: -30%; top: -30%; }

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
    .lu-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 50px;
        padding: 4px 14px;
        font-size: 0.78rem;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
    }
    .lu-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        color: var(--white);
        font-weight: 600;
        font-size: 0.82rem;
        padding: 8px 18px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        margin-top: auto;
    }
    .lu-card:hover .lu-btn {
        background: var(--white);
        color: var(--primary);
        border-color: var(--white);
    }

    /* Modal */
    .px-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        z-index: 9000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .px-modal-overlay.active { display: flex; }

    .px-modal {
        background: var(--white);
        border-radius: 16px;
        width: 100%;
        max-width: 760px;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 24px 60px rgba(0,0,0,0.25);
        overflow: hidden;
    }
    .px-modal-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 24px 28px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, var(--primary) 0%, #1a3a8a 100%);
        color: var(--white);
        flex-shrink: 0;
    }
    .px-modal-header-icon {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,0.15);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fbbf24;
        flex-shrink: 0;
    }
    .px-modal-header h3 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        line-height: 1.4;
    }
    .px-modal-header p {
        margin: 2px 0 0;
        font-size: 0.82rem;
        opacity: 0.8;
    }
    .px-modal-close {
        margin-left: auto;
        background: rgba(255,255,255,0.15);
        border: none;
        color: var(--white);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.2s;
    }
    .px-modal-close:hover { background: rgba(255,255,255,0.3); }

    .px-modal-body {
        overflow-y: auto;
        padding: 24px 28px;
        flex: 1;
    }

    .px-item {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid var(--border);
        align-items: flex-start;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s;
        border-radius: 8px;
        padding: 14px 12px;
        margin: 0 -12px;
    }
    .px-item:last-child { border-bottom: none; }
    .px-item:hover { background: var(--accent-light); }
    .px-item-num {
        width: 32px;
        height: 32px;
        background: var(--primary);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .px-item-body { flex: 1; min-width: 0; }
    .px-item-judul {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 4px;
        line-height: 1.4;
    }
    .px-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 0.78rem;
        color: var(--text-light);
    }
    .px-item-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .px-item-arrow {
        color: var(--primary);
        font-size: 0.85rem;
        margin-top: 4px;
        flex-shrink: 0;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .px-item:hover .px-item-arrow { opacity: 1; }

    .px-empty {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-light);
    }
    .px-empty i { font-size: 2rem; margin-bottom: 12px; display: block; opacity: 0.4; }

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
    .ku-list { list-style: none; padding: 0; margin: 0; }
    .ku-list li { position: relative; padding-left: 20px; margin-bottom: 24px; }
    .ku-list li::before {
        content: '•'; position: absolute; left: 0; top: -1px;
        color: var(--primary); font-size: 1.4rem; font-weight: bold; line-height: 1;
    }
    .ku-list li:last-child { margin-bottom: 0; }
    .ku-list strong { color: var(--primary); display: block; font-size: 1rem; margin-bottom: 6px; font-weight: 600; }
    .ku-list p { color: var(--text-light); margin: 0; font-size: 0.95rem; line-height: 1.6; }

    @media (max-width: 992px) {
        .tk-top-section { grid-template-columns: 1fr; }
        .ku-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .lu-card { flex: 1 1 calc(50% - 24px); }
    }
    @media (max-width: 480px) {
        .lu-card { flex: 1 1 100%; max-width: 100%; }
    }
</style>
@endpush

@section('content')

@php
    $iconMap = [
        'Pengkajian dan Penelitian'                    => 'fas fa-microscope',
        'Pendampingan Perencanaan Pembangunan Daerah'   => 'fas fa-map-marked-alt',
        'Evaluasi Program dan Kinerja Pembangunan'      => 'fas fa-chart-line',
        'Pengembangan Database dan Sistem Informasi'    => 'fas fa-database',
        'Pemberdayaan Masyarakat'                      => 'fas fa-users',
        'Pendidikan dan Pelatihan'                     => 'fas fa-user-graduate',
        'Advokasi dan Konsultasi Kebijakan Pembangunan' => 'fas fa-gavel',
    ];
@endphp

<div class="tk-container">

    <!-- Top Section -->
    <div class="tk-top-section">
        <h2 class="tk-box-title" style="margin-bottom:12px;font-size:1.5rem;">Pengalaman {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'LPPSP' }}</h2>
        <p style="color:var(--text);line-height:1.7;font-size:1.05rem;font-weight:500;margin:0;">
            @if(isset($profile) && $profile->deskripsi_pengalaman)
                {!! nl2br(e($profile->deskripsi_pengalaman)) !!}
            @else
                {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'LPPSP' }} memiliki pengalaman layanan pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, dan penguatan tata kelola pemerintahan pada bidang sosial, bidang pembangunan daerah dan pemerintahan, bidang kemanusiaan, dan bidang keagamaan.
            @endif
        </p>
    </div>

    <!-- Rekam Jejak Layanan -->
    <div class="tk-box" style="padding:10px 0;">
        <h3 class="tk-box-title" style="text-align:center;margin-bottom:40px;font-size:1.8rem;">Rekam Jejak Layanan</h3>
        <div class="lu-container">
            @forelse($layanans as $layanan)
                @php
                    $icon  = $iconMap[$layanan->judul] ?? 'fas fa-check-circle';
                    $items = $pengalamanByLayanan->get($layanan->id, collect());
                    $count = $items->count();
                @endphp
                <div class="lu-card" onclick="openPxModal({{ $layanan->id }})">
                    <div class="lu-icon-box"><i class="{{ $icon }}"></i></div>
                    <h4 class="lu-title">{{ $layanan->judul }}</h4>
                    @if($layanan->deskripsi)
                        <p class="lu-desc">{{ $layanan->deskripsi }}</p>
                    @endif
                    <span class="lu-count-badge">
                        <i class="fas fa-folder-open"></i>
                        {{ $count }} {{ $count === 1 ? 'kegiatan' : 'kegiatan' }}
                    </span>
                    <span class="lu-btn"><i class="fas fa-arrow-right"></i> Lihat selengkapnya</span>
                </div>
            @empty
                <div class="lu-card" style="pointer-events:none;">
                    <div class="lu-icon-box"><i class="fas fa-briefcase"></i></div>
                    <h4 class="lu-title">Belum ada data layanan</h4>
                </div>
            @endforelse

            @if($pengalamanLain->isNotEmpty())
                @php $countLain = $pengalamanLain->count(); @endphp
                <div class="lu-card" onclick="openPxModal('lain')">
                    <div class="lu-icon-box"><i class="fas fa-layer-group"></i></div>
                    <h4 class="lu-title">Kegiatan Lainnya</h4>
                    <p class="lu-desc">Kegiatan dan pengalaman di luar kategori layanan utama.</p>
                    <span class="lu-count-badge">
                        <i class="fas fa-folder-open"></i>
                        {{ $countLain }} kegiatan
                    </span>
                    <span class="lu-btn"><i class="fas fa-arrow-right"></i> Lihat selengkapnya</span>
                </div>
            @endif
        </div>
    </div>


</div>

<!-- Modals per Layanan -->
@foreach($layanans as $layanan)
    @php
        $icon  = $iconMap[$layanan->judul] ?? 'fas fa-check-circle';
        $items = $pengalamanByLayanan->get($layanan->id, collect());
    @endphp
    <div class="px-modal-overlay" id="px-modal-{{ $layanan->id }}">
        <div class="px-modal">
            <div class="px-modal-header">
                <div class="px-modal-header-icon"><i class="{{ $icon }}"></i></div>
                <div>
                    <h3>{{ $layanan->judul }}</h3>
                    <p>{{ $items->count() }} kegiatan terdokumentasi</p>
                </div>
                <button class="px-modal-close" onclick="closePxModal({{ $layanan->id }})"><i class="fas fa-times"></i></button>
            </div>
            <div class="px-modal-body">
                @if($items->isEmpty())
                    <div class="px-empty">
                        <i class="fas fa-folder-open"></i>
                        Belum ada kegiatan untuk layanan ini.
                    </div>
                @else
                    @foreach($items as $i => $px)
                        <a href="{{ route('pengalaman.show', $px->id) }}" class="px-item">
                            <div class="px-item-num">{{ $i + 1 }}</div>
                            <div class="px-item-body">
                                <div class="px-item-judul">{{ $px->judul }}</div>
                                <div class="px-item-meta">
                                    @if($px->klien)
                                        <span><i class="fas fa-building"></i> {{ $px->klien }}</span>
                                    @endif
                                    @if($px->tahun)
                                        <span><i class="fas fa-calendar-alt"></i> {{ $px->tahun }}</span>
                                    @endif
                                    @if($px->lokasi)
                                        <span><i class="fas fa-map-marker-alt"></i> {{ $px->lokasi }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="px-item-arrow"><i class="fas fa-chevron-right"></i></div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endforeach

@if($pengalamanLain->isNotEmpty())
    <div class="px-modal-overlay" id="px-modal-lain">
        <div class="px-modal">
            <div class="px-modal-header">
                <div class="px-modal-header-icon"><i class="fas fa-layer-group"></i></div>
                <div>
                    <h3>Kegiatan Lainnya</h3>
                    <p>{{ $pengalamanLain->count() }} kegiatan terdokumentasi</p>
                </div>
                <button class="px-modal-close" onclick="closePxModal('lain')"><i class="fas fa-times"></i></button>
            </div>
            <div class="px-modal-body">
                @foreach($pengalamanLain as $i => $px)
                    <a href="{{ route('pengalaman.show', $px->id) }}" class="px-item">
                        <div class="px-item-num">{{ $i + 1 }}</div>
                        <div class="px-item-body">
                            <div class="px-item-judul">{{ $px->judul }}</div>
                            <div class="px-item-meta">
                                @if($px->klien)
                                    <span><i class="fas fa-building"></i> {{ $px->klien }}</span>
                                @endif
                                @if($px->tahun)
                                    <span><i class="fas fa-calendar-alt"></i> {{ $px->tahun }}</span>
                                @endif
                                @if($px->lokasi)
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $px->lokasi }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="px-item-arrow"><i class="fas fa-chevron-right"></i></div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
function openPxModal(id) {
    document.getElementById('px-modal-' + id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closePxModal(id) {
    document.getElementById('px-modal-' + id).classList.remove('active');
    document.body.style.overflow = '';
}
document.querySelectorAll('.px-modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) {
        if (e.target === el) {
            el.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.px-modal-overlay.active').forEach(function(el) {
            el.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
});
</script>
@endpush

@endsection
