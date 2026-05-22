<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin LPPSP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @php $layoutProfile = \App\Models\Profile::first(); @endphp
    @if($layoutProfile && $layoutProfile->favicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($layoutProfile->favicon) }}">
        <link rel="shortcut icon" href="{{ Storage::url($layoutProfile->favicon) }}">
        <link rel="apple-touch-icon" href="{{ Storage::url($layoutProfile->favicon) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='6' fill='%231e3a8a'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' fill='white' font-size='14' font-weight='bold' font-family='Arial'%3EL%3C/text%3E%3C/svg%3E">
    @endif
    @stack('styles')
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-brand" style="display: flex; align-items: center; gap: 10px;">
            @if($layoutProfile && $layoutProfile->logo)
                <img src="{{ Storage::url($layoutProfile->logo) }}" alt="Logo" style="height: 40px; border-radius: 8px; background: white; padding: 4px; object-fit: contain;">
                <span style="font-size: 1rem;">{{ $layoutProfile->singkatan ?? 'LPPSP' }}</span>
            @else
                <i class="fas fa-building"></i>
                <span>LPPSP Admin</span>
            @endif
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a></li>
                @if(auth()->user()->role === 'admin')
                <li><a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                    <i class="fas fa-id-card"></i> Profil Lembaga
                </a></li>
                <li><a href="{{ route('admin.user-profile.edit') }}" class="{{ request()->routeIs('admin.user-profile*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> Profil Pengguna
                </a></li>
                <li><a href="{{ route('admin.layanan.index') }}" class="{{ request()->routeIs('admin.layanan*') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell"></i> Layanan
                </a></li>
                <li><a href="{{ route('admin.pengalaman.index') }}" class="{{ request()->routeIs('admin.pengalaman*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Pengalaman
                </a></li>
                <li><a href="{{ route('admin.klien-mitra.index') }}" class="{{ request()->routeIs('admin.klien-mitra*') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i> Klien/Mitra
                </a></li>
                <li><a href="{{ route('admin.tim-organisasi.index') }}" class="{{ request()->routeIs('admin.tim-organisasi*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Tim Organisasi
                </a></li>
                <li><a href="{{ route('admin.galeri-slider.index') }}" class="{{ request()->routeIs('admin.galeri-slider*') ? 'active' : '' }}">
                    <i class="fas fa-id-badge"></i> Tim Admin
                </a></li>
                <li><a href="{{ route('admin.testimoni.index') }}" class="{{ request()->routeIs('admin.testimoni*') ? 'active' : '' }}">
                    <i class="fas fa-quote-left"></i> Testimoni
                </a></li>
                @php
                    $pubGroupActive = request()->routeIs('admin.publikasi*') || request()->routeIs('admin.jurnal*') || request()->routeIs('admin.kategori-publikasi*');
                @endphp
                <li class="nav-group {{ $pubGroupActive ? 'open' : '' }}">
                    <button class="nav-group-toggle" onclick="toggleNavGroup(this)">
                        <span><i class="fas fa-newspaper"></i> Publikasi</span>
                        <i class="fas fa-chevron-down nav-group-arrow"></i>
                    </button>
                    <ul class="nav-sub">
                        <li><a href="{{ route('admin.publikasi.index') }}" class="{{ request()->routeIs('admin.publikasi*') && !request()->routeIs('admin.kategori-publikasi*') ? 'active' : '' }}">
                            <i class="fas fa-list"></i> Semua Publikasi
                        </a></li>
                        <li><a href="{{ route('admin.jurnal.index') }}" class="{{ request()->routeIs('admin.jurnal*') ? 'active' : '' }}">
                            <i class="fas fa-book-open"></i> Jurnal Ilmiah
                        </a></li>
                        <li><a href="{{ route('admin.kategori-publikasi.index') }}" class="{{ request()->routeIs('admin.kategori-publikasi*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i> Kategori
                        </a></li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> Pengguna
                </a></li>
                <li><a href="{{ route('admin.kontak.index') }}" class="{{ request()->routeIs('admin.kontak*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Pesan Kontak
                    @php $pesanBaru = \App\Models\Kontak::where('sudah_dibaca', false)->count(); @endphp
                    @if($pesanBaru > 0)
                        <span class="badge-count">{{ $pesanBaru }}</span>
                    @endif
                </a></li>
                <li style="margin-top:8px;border-top:1px solid rgba(255,255,255,0.08);padding-top:8px;">
                    <a href="{{ route('admin.setting.index') }}" class="{{ request()->routeIs('admin.setting*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Pengaturan
                        @if($layoutProfile && $layoutProfile->maintenance_mode)
                            <span style="background:#fef3c7;color:#d97706;font-size:0.6rem;font-weight:700;padding:2px 7px;border-radius:50px;border:1px solid #fcd34d;margin-left:2px;">Maintenance</span>
                        @endif
                    </a>
                </li>
                @endif {{-- end admin role --}}
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('beranda') }}" target="_blank"><i class="fas fa-external-link-alt"></i> Lihat Website</a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <a href="{{ route('admin.user-profile.edit') }}" class="admin-user" style="text-decoration:none; color:inherit; cursor:pointer;">
                <i class="fas fa-user-circle"></i>
                <span>{{ auth()->user()->name ?? 'Admin' }}</span>
            </a>
        </header>

        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
<script>
function toggleNavGroup(btn) {
    btn.closest('.nav-group').classList.toggle('open');
}
</script>
@stack('scripts')
</body>
</html>
