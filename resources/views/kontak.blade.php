@extends('layouts.app')
@section('title', 'Kontak')

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
        margin: 0;
    }

    /* Contact Grid */
    .contact-3-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    
    .contact-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 32px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
    }
    
    .contact-card-title {
        color: var(--primary);
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 20px;
    }

    /* Info Text */
    .info-text {
        color: var(--text);
        line-height: 1.7;
        font-size: 0.95rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 16px;
    }
    .form-control {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--text);
        background-color: #fafafa;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 3px rgba(26, 111, 196, 0.1);
    }
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    .btn-submit {
        background: var(--primary);
        color: var(--white);
        font-weight: 700;
        font-size: 0.9rem;
        padding: 12px 24px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 8px;
    }
    .btn-submit:hover {
        background: var(--gold);
        color: var(--primary);
    }

    /* Slider */
    .kontak-tim-card {
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .kontak-slider-wrap {
        position: relative;
        flex: 1;
        min-height: 380px;
        overflow: hidden;
        background: #e8f0fb;
    }
    .kontak-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 0.7s ease;
        background: #e8f0fb;
        pointer-events: none;
    }
    .kontak-slide.active {
        opacity: 1;
        pointer-events: auto;
    }
    .kontak-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
        display: block;
    }
    .kontak-slide-caption {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(5,20,60,0.88) 70%);
        color: #fff;
        padding: 40px 14px 14px;
        z-index: 2;
        pointer-events: none;
    }
    .kontak-slide-caption-name {
        font-size: 0.95rem;
        font-weight: 800;
        display: block;
        margin-bottom: 2px;
        line-height: 1.3;
    }
    .kontak-slide-caption-jabatan {
        font-size: 0.72rem;
        font-weight: 600;
        color: rgba(255,255,255,0.8);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        display: block;
        margin-bottom: 8px;
    }
    .kontak-slide-socials {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        pointer-events: auto;
    }
    .kontak-slide-social-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 4px 11px;
        border-radius: 50px;
        text-decoration: none;
        border: 1.5px solid rgba(255,255,255,0.5);
        color: #fff;
        transition: all 0.2s;
        backdrop-filter: blur(4px);
        position: relative;
        z-index: 10;
        cursor: pointer;
        pointer-events: auto;
    }
    .kontak-slide-social-btn:hover { background: rgba(255,255,255,0.3); border-color: #fff; color: #fff; }
    .kontak-slider-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
        padding: 10px 0 14px;
        background: var(--white);
    }
    .kontak-slider-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #cbd5e1; cursor: pointer;
        transition: background 0.2s, transform 0.2s;
        border: none;
    }
    .kontak-slider-dot.active { background: #1a6fc4; transform: scale(1.25); }

    @media (max-width: 992px) {
        .contact-3-grid { grid-template-columns: 1fr; gap: 20px; }
    }
</style>
@endpush

@section('content')


<div class="tk-container">

    @if(session('success'))
    <div style="background: #e6ffed; border: 1px solid #34d058; color: #22863a; padding: 16px; border-radius: var(--radius); margin-bottom: 20px;">
        <strong>Sukses!</strong> {{ session('success') }}
    </div>
    @endif

    <!-- Top Section -->
    <div class="tk-top-section">
        <h2 class="tk-box-title">Kontak {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'LPPSP' }}</h2>
        <p class="tk-top-desc">
            Mari Bermitra!!! {{ isset($profile) && $profile->singkatan ? $profile->singkatan : 'LPPSP' }} membuka peluang kerjasama dalam layanan pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, dan penguatan tata kelola pemerintahan pada bidang sosial, bidang pembangunan daerah dan pemerintahan, bidang kemanusiaan, dan bidang keagamaan.
        </p>
    </div>

    <!-- Contact Grid -->
    <div class="contact-3-grid">
        
        <!-- Informasi Kontak -->
        <div class="contact-card">
            <h3 class="contact-card-title">Informasi Kontak</h3>
            <p class="info-text">
                @if($profile)
                    Alamat: {{ $profile->alamat }}<br><br>
                    Telp: {{ $profile->telepon }}<br><br>
                    Email: {{ $profile->email }}<br><br>
                    Website: {{ $profile->website ?? 'lppspsemarang.org' }}
                @else
                    Alamat: Bumi Wana Mukti Blok A4 No 31, Kelurahan Sambiroto, Kecamatan Tembalang, Kota Semarang;<br><br>
                    Telp: +6224-6705577, +6224-6701321;<br><br>
                    Fax: +6224-6701321;<br><br>
                    Email: lppsp_semarang@yahoo.com;<br><br>
                    Website: lppspsemarang.org
                @endif
            </p>
        </div>

        <!-- Formulir Kontak -->
        <div class="contact-card">
            <h3 class="contact-card-title">Formulir Kontak</h3>
            <form action="{{ route('kontak.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="subjek" class="form-control" placeholder="Subjek" required>
                </div>
                <div class="form-group">
                    <textarea name="pesan" class="form-control" placeholder="Pesan" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Kirim Pesan</button>
            </form>
        </div>

        <!-- Tim Admin -->
        <div class="kontak-tim-card">
            <div class="kontak-slider-wrap" id="kontakSliderWrap">
                {{-- Label overlay atas --}}
                <div style="position:absolute;top:14px;left:14px;z-index:3;background:linear-gradient(135deg,#0d2b5e,#1a6fc4);color:#fff;font-size:0.78rem;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:5px 14px;border-radius:50px;display:inline-flex;align-items:center;gap:6px;">
                    <i class="fas fa-id-badge"></i> Tim Admin
                </div>
                @if($sliders->isNotEmpty())
                    @foreach($sliders as $i => $s)
                    <div class="kontak-slide {{ $i === 0 ? 'active' : '' }}" id="kslide-{{ $i }}">
                        <img src="{{ Storage::url($s->foto) }}" alt="{{ $s->nama }}">
                        <div class="kontak-slide-caption">
                            @if($s->nama)<span class="kontak-slide-caption-name">{{ $s->nama }}</span>@endif
                            @if($s->jabatan)<span class="kontak-slide-caption-jabatan">{{ $s->jabatan }}</span>@endif
                            <div class="kontak-slide-socials">
                                @if($s->wa)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$s->wa) }}" target="_blank" class="kontak-slide-social-btn">
                                    <i class="fab fa-whatsapp"></i> WA
                                </a>
                                @endif
                                @if($s->instagram)
                                <a href="{{ $s->instagram }}" target="_blank" class="kontak-slide-social-btn">
                                    <i class="fab fa-instagram"></i> IG
                                </a>
                                @endif
                                @if($s->facebook)
                                <a href="{{ $s->facebook }}" target="_blank" class="kontak-slide-social-btn">
                                    <i class="fab fa-facebook"></i> FB
                                </a>
                                @endif
                                @if($s->linkedin)
                                <a href="{{ $s->linkedin }}" target="_blank" class="kontak-slide-social-btn">
                                    <i class="fab fa-linkedin"></i> LI
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <div style="display:flex;align-items:center;justify-content:center;height:380px;flex-direction:column;color:#94a3b8;">
                    <i class="fas fa-id-badge" style="font-size:2.5rem;margin-bottom:10px;"></i>
                    <span style="font-size:0.9rem;">Belum ada anggota Tim Admin</span>
                </div>
                @endif
            </div>
            @if(isset($sliders) && $sliders->count() > 1)
            <div class="kontak-slider-dots" id="kontakSliderDots">
                @foreach($sliders as $i => $s)
                <button class="kontak-slider-dot {{ $i === 0 ? 'active' : '' }}" onclick="goKSlide({{ $i }})"></button>
                @endforeach
            </div>
            @endif
        </div>

    </div>

</div>

@push('scripts')
<script>
(function() {
    const slides = document.querySelectorAll('.kontak-slide');
    const dots   = document.querySelectorAll('.kontak-slider-dot');
    if (slides.length <= 1) return;

    let current = 0, timer;

    window.goKSlide = function(idx) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = idx;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
        resetTimer();
    };

    function next() { goKSlide((current + 1) % slides.length); }
    function resetTimer() { clearInterval(timer); timer = setInterval(next, 4500); }
    resetTimer();
})();
</script>
@endpush

@endsection
