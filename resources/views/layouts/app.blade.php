<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php $layoutProfile = \App\Models\Profile::first(); @endphp
    <title>@yield('title', $layoutProfile->singkatan ?? 'LPPSP') - {{ $layoutProfile->nama_lembaga ?? 'Lembaga Pengkajian dan Pengembangan Sumberdaya Pembangunan' }}</title>
    <meta name="description" content="@yield('description', ($layoutProfile->singkatan ?? 'LPPSP') . ' - ' . ($layoutProfile->nama_lembaga ?? 'Lembaga Pengkajian dan Pengembangan Sumberdaya Pembangunan'))">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    @if($layoutProfile && $layoutProfile->favicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($layoutProfile->favicon) }}">
        <link rel="shortcut icon" href="{{ Storage::url($layoutProfile->favicon) }}">
        <link rel="apple-touch-icon" href="{{ Storage::url($layoutProfile->favicon) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='6' fill='%231e3a8a'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' fill='white' font-size='14' font-weight='bold' font-family='Arial'%3EL%3C/text%3E%3C/svg%3E">
    @endif
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar" id="navbar">
    <div class="container">
        <a href="{{ route('beranda') }}" class="navbar-brand">
            @php $profile = \App\Models\Profile::first(); @endphp
            @if($profile && $profile->logo)
                <img src="{{ Storage::url($profile->logo) }}" alt="Logo {{ $profile->singkatan ?? 'LPPSP' }}" class="navbar-logo">
            @endif
            <span class="brand-text">
                <strong>{{ $profile->singkatan ?? 'LPPSP' }}</strong>
                <small>{{ $profile->nama_lembaga ?? 'Lembaga Pengkajian dan Pengembangan Sumberdaya Pembangunan' }}</small>
            </span>
        </a>

        <button class="navbar-toggle" id="navToggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-menu" id="navMenu">
            <li><a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('tentang-kami') }}" class="nav-link {{ request()->routeIs('tentang-kami') ? 'active' : '' }}">Tentang Kami</a></li>
            <li><a href="{{ route('layanan') }}" class="nav-link {{ request()->routeIs('layanan') ? 'active' : '' }}">Layanan</a></li>
            <li><a href="{{ route('pengalaman') }}" class="nav-link {{ request()->routeIs('pengalaman') ? 'active' : '' }}">Pengalaman</a></li>
            <li><a href="{{ route('klien-mitra') }}" class="nav-link {{ request()->routeIs('klien-mitra') ? 'active' : '' }}">Klien/Mitra</a></li>
            <li><a href="{{ route('testimoni') }}" class="nav-link {{ request()->routeIs('testimoni') ? 'active' : '' }}">Testimoni</a></li>
            <li><a href="{{ route('publikasi') }}" class="nav-link {{ request()->routeIs('publikasi') ? 'active' : '' }}">Publikasi</a></li>
            <li><a href="{{ route('kontak') }}" class="nav-link nav-btn {{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a></li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                @if(isset($profile) && $profile->logo)
                    <img src="{{ Storage::url($profile->logo) }}" alt="Logo {{ $profile->singkatan ?? 'LPPSP' }}" class="footer-logo">
                @else
                    <h3 class="footer-brand">{{ $profile->singkatan ?? 'LPPSP' }}</h3>
                @endif
                <p class="footer-desc">
                    {{-- Footer slogan: footer_slogan → deskripsi_singkat → tagline → fallback --}}
                    @if(isset($profile) && $profile->footer_slogan)
                        {{ $profile->footer_slogan }}
                    @elseif(isset($profile) && $profile->deskripsi_singkat)
                        {{ $profile->deskripsi_singkat }}
                    @elseif(isset($profile) && $profile->tagline)
                        {{ strip_tags($profile->tagline) }}
                    @else
                        Mitra terpercaya dalam riset dan konsultasi pembangunan daerah.
                    @endif
                </p>
                <div class="social-links">
                    @if(isset($profile) && $profile->facebook)
                        <a href="{{ $profile->facebook }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(isset($profile) && $profile->instagram)
                        <a href="{{ $profile->instagram }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(isset($profile) && $profile->twitter)
                        <a href="{{ $profile->twitter }}" target="_blank" title="X / Twitter"><i class="fab fa-x-twitter"></i></a>
                    @endif
                    @if(isset($profile) && $profile->youtube)
                        <a href="{{ $profile->youtube }}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if(isset($profile) && $profile->tiktok)
                        <a href="{{ $profile->tiktok }}" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    @endif
                    @if(isset($profile) && $profile->linkedin)
                        <a href="{{ $profile->linkedin }}" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                    @if(isset($profile) && $profile->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$profile->whatsapp) }}" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    @endif
                    @if(isset($profile) && $profile->telegram)
                        <a href="{{ Str::startsWith($profile->telegram,'http') ? $profile->telegram : 'https://t.me/'.ltrim($profile->telegram,'@') }}" target="_blank" title="Telegram"><i class="fab fa-telegram"></i></a>
                    @endif
                    @if(isset($profile) && $profile->threads)
                        <a href="{{ $profile->threads }}" target="_blank" title="Threads"><i class="fas fa-at"></i></a>
                    @endif
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt"></i> 
                        <div>
                            <strong style="color:var(--gold);">Alamat</strong><br>
                            {!! isset($profile) && $profile->alamat ? nl2br(e($profile->alamat)) : 'Bumi Wana Mukti Blok A4 No 31, Kel. Sambiroto, Kec. Tembalang, Kota Semarang' !!}
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-phone-alt"></i> 
                        <div>
                            <strong style="color:var(--gold);">Telepon / Fax</strong><br>
                            {!! isset($profile) && $profile->telepon ? nl2br(e($profile->telepon)) : '+6224-6705577 <br> +6224-6701321' !!}
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i> 
                        <div>
                            <strong style="color:var(--gold);">Email</strong><br>
                            {{ isset($profile) && $profile->email ? $profile->email : 'lppsp_semarang@yahoo.com' }}
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-globe"></i> 
                        <div>
                            <strong style="color:var(--gold);">Website</strong><br>
                            {{ isset($profile) && $profile->website ? $profile->website : 'lppspsemarang.org' }}
                        </div>
                    </li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Lokasi {{ $profile->singkatan ?? 'LPPSP' }}</h4>
                <div class="footer-map-container" style="width: 100%; height: 220px; border-radius: 12px; overflow: hidden; border: 2px solid rgba(255,255,255,0.1);">
                    @if(isset($profile) && $profile->maps_embed)
                        {!! $profile->maps_embed !!}
                    @else
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.5843477818464!2d110.45781607593672!3d-7.058000471126744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708c1c4f4a9b6d%3A0xc345f7bd4c8b21ba!2sBumi%20Wana%20Mukti!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }}
                @if(isset($profile) && $profile->footer_copyright)
                    {{ $profile->footer_copyright }}
                @else
                    {{ $profile->singkatan ?? 'LPPSP' }}. Semua hak dilindungi.
                @endif
            </p>
        </div>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
