@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
<style>
/* ── Welcome Banner ─────────────────────── */
.db-welcome {
    background: linear-gradient(135deg, #0d2b5e 0%, #1a4a9e 55%, #1a6fc4 100%);
    border-radius: 18px;
    padding: 32px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(13,43,94,0.22);
}
.db-welcome::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.db-welcome::after {
    content: '';
    position: absolute;
    bottom: -80px; right: 120px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}
.db-welcome-text h2 {
    font-size: 1.55rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 6px;
}
.db-welcome-text p {
    color: rgba(255,255,255,0.75);
    font-size: 0.92rem;
    margin: 0;
}
.db-welcome-time {
    text-align: right;
    color: rgba(255,255,255,0.85);
    font-size: 0.82rem;
    white-space: nowrap;
    flex-shrink: 0;
}
.db-welcome-time strong {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    color: #f59e0b;
    line-height: 1;
    margin-bottom: 4px;
}

/* ── Stat Grid ──────────────────────────── */
.db-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}
.db-stat {
    background: #fff;
    border-radius: 14px;
    padding: 20px 22px;
    border: 1px solid #e8edf5;
    box-shadow: 0 2px 12px rgba(13,43,94,0.06);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
    cursor: default;
}
a.db-stat { cursor: pointer; }
a.db-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(13,43,94,0.13);
}
.db-stat-icon {
    width: 50px; height: 50px;
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.db-stat-num {
    font-size: 1.75rem;
    font-weight: 800;
    color: #0d2b5e;
    line-height: 1;
    margin-bottom: 3px;
}
.db-stat-label {
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Stat Colors */
.ic-blue   { background:#dbeafe; color:#1d4ed8; }
.ic-green  { background:#dcfce7; color:#16a34a; }
.ic-amber  { background:#fef3c7; color:#d97706; }
.ic-red    { background:#fee2e2; color:#dc2626; }
.ic-purple { background:#ede9fe; color:#7c3aed; }
.ic-pink   { background:#fce7f3; color:#db2777; }
.ic-teal   { background:#ccfbf1; color:#0d9488; }
.ic-slate  { background:#f1f5f9; color:#475569; }
.ic-indigo { background:#e0e7ff; color:#4338ca; }

/* ── Bottom Grid ────────────────────────── */
.db-bottom {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
}

/* ── Panel ──────────────────────────────── */
.db-panel {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e8edf5;
    box-shadow: 0 2px 12px rgba(13,43,94,0.06);
    overflow: hidden;
}
.db-panel-head {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.db-panel-head h3 {
    font-size: 0.95rem;
    font-weight: 800;
    color: #0d2b5e;
    margin: 0;
    display: flex; align-items: center; gap: 8px;
}
.db-panel-head a {
    font-size: 0.78rem;
    color: #1a6fc4;
    font-weight: 600;
    text-decoration: none;
}
.db-panel-head a:hover { text-decoration: underline; }

/* Message list */
.db-msg-list { padding: 8px 0; }
.db-msg-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 24px;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.15s;
}
.db-msg-item:last-child { border-bottom: none; }
.db-msg-item:hover { background: #f8fafc; }
.db-msg-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #1a6fc4, #0d2b5e);
    color: #fff; font-weight: 800; font-size: 0.9rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.db-msg-avatar.unread { background: linear-gradient(135deg, #f59e0b, #d97706); }
.db-msg-info { flex: 1; min-width: 0; }
.db-msg-name {
    font-size: 0.85rem;
    font-weight: 700;
    color: #0d2b5e;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.db-msg-subj {
    font-size: 0.75rem;
    color: #64748b;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.db-msg-meta {
    font-size: 0.7rem;
    color: #94a3b8;
    text-align: right;
    flex-shrink: 0;
}
.db-unread-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #f59e0b; flex-shrink: 0;
}
.db-msg-empty {
    padding: 40px 24px;
    text-align: center;
    color: #94a3b8;
    font-size: 0.9rem;
}

/* Quick actions */
.db-quick { padding: 16px; display: flex; flex-direction: column; gap: 10px; }
.db-quick-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    border: 1px solid #e8edf5;
    background: #fafbfc;
    color: #0d2b5e;
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
}
.db-quick-btn:hover {
    background: linear-gradient(135deg, #0d2b5e, #1a6fc4);
    color: #fff;
    border-color: transparent;
    transform: translateX(4px);
}
.db-quick-btn i { width: 16px; text-align: center; }

/* Publikasi mini */
.db-pub-list { padding: 8px 0; }
.db-pub-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 24px;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.15s;
}
.db-pub-item:last-child { border-bottom: none; }
.db-pub-item:hover { background: #f8fafc; }
.db-pub-num {
    width: 28px; height: 28px; border-radius: 8px;
    background: #e8f0fb; color: #1a6fc4;
    font-weight: 800; font-size: 0.75rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 2px;
}
.db-pub-title {
    font-size: 0.83rem;
    font-weight: 700;
    color: #0d2b5e;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.db-pub-date { font-size: 0.7rem; color: #94a3b8; margin-top: 2px; }

@media (max-width: 1100px) {
    .db-stat-grid { grid-template-columns: repeat(2, 1fr); }
    .db-bottom { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .db-stat-grid { grid-template-columns: repeat(2, 1fr); }
    .db-welcome { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')

@if(auth()->user()->role === 'viewer')
{{-- Viewer Dashboard --}}
<div style="max-width:560px;margin:60px auto;text-align:center;">
    <div style="width:80px;height:80px;background:#ede9fe;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:2rem;color:#7c3aed;">
        <i class="fas fa-globe"></i>
    </div>
    <h2 style="font-size:1.6rem;font-weight:800;color:#1e293b;margin-bottom:10px;">
        Selamat datang, {{ auth()->user()->name }}!
    </h2>
    <p style="color:#64748b;font-size:1rem;line-height:1.7;margin-bottom:32px;">
        Akun Anda memiliki akses <strong>Viewer</strong>.<br>
        Anda dapat mengunjungi website LPPSP melalui tombol di bawah ini.
    </p>
    <a href="{{ route('beranda') }}" target="_blank"
        style="display:inline-flex;align-items:center;gap:10px;background:#1e3a8a;color:#fff;padding:14px 32px;border-radius:12px;font-weight:700;text-decoration:none;font-size:1rem;box-shadow:0 4px 16px rgba(30,58,138,0.2);">
        <i class="fas fa-external-link-alt"></i> Lihat Website LPPSP
    </a>
</div>
@else
{{-- Welcome Banner --}}
<div class="db-welcome">
    <div class="db-welcome-text">
        <h2><i class="fas fa-hand-wave" style="color:#f59e0b;margin-right:10px;"></i>Selamat datang, {{ auth()->user()->name }}!</h2>
        <p>
            {{ isset($profile) && $profile->nama_lembaga ? $profile->nama_lembaga : 'LPPSP' }} &mdash;
            Panel Administrasi Website &bull; Semua data terkini tersedia di bawah ini.
        </p>
    </div>
    <div class="db-welcome-time">
        <strong id="db-clock">--:--</strong>
        <span id="db-date">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
    </div>
</div>

{{-- Stat Grid --}}
<div class="db-stat-grid">
    <a href="{{ route('admin.layanan.index') }}" class="db-stat">
        <div class="db-stat-icon ic-blue"><i class="fas fa-concierge-bell"></i></div>
        <div>
            <div class="db-stat-num">{{ $stats['layanans'] }}</div>
            <div class="db-stat-label">Layanan</div>
        </div>
    </a>
    <a href="{{ route('admin.pengalaman.index') }}" class="db-stat">
        <div class="db-stat-icon ic-green"><i class="fas fa-history"></i></div>
        <div>
            <div class="db-stat-num">{{ $stats['pengalamans'] }}</div>
            <div class="db-stat-label">Pengalaman</div>
        </div>
    </a>
    <a href="{{ route('admin.klien-mitra.index') }}" class="db-stat">
        <div class="db-stat-icon ic-teal"><i class="fas fa-handshake"></i></div>
        <div>
            <div class="db-stat-num">{{ $stats['klien_mitras'] }}</div>
            <div class="db-stat-label">Klien & Mitra</div>
        </div>
    </a>
    <a href="{{ route('admin.publikasi.index') }}" class="db-stat">
        <div class="db-stat-icon ic-amber"><i class="fas fa-newspaper"></i></div>
        <div>
            <div class="db-stat-num">{{ $stats['publikasis'] }}</div>
            <div class="db-stat-label">Publikasi</div>
        </div>
    </a>
    <a href="{{ route('admin.testimoni.index') }}" class="db-stat">
        <div class="db-stat-icon ic-purple"><i class="fas fa-quote-left"></i></div>
        <div>
            <div class="db-stat-num">{{ $stats['testimonis'] }}</div>
            <div class="db-stat-label">Testimoni</div>
        </div>
    </a>
    <a href="{{ route('admin.tim-organisasi.index') }}" class="db-stat">
        <div class="db-stat-icon ic-indigo"><i class="fas fa-users"></i></div>
        <div>
            <div class="db-stat-num">{{ $stats['tim_organisasi'] }}</div>
            <div class="db-stat-label">Tim Organisasi</div>
        </div>
    </a>
    <a href="{{ route('admin.galeri-slider.index') }}" class="db-stat">
        <div class="db-stat-icon ic-pink"><i class="fas fa-id-badge"></i></div>
        <div>
            <div class="db-stat-num">{{ $stats['tim_admin'] }}</div>
            <div class="db-stat-label">Tim Admin</div>
        </div>
    </a>
    <a href="{{ route('admin.kontak.index') }}" class="db-stat">
        <div class="db-stat-icon ic-red"><i class="fas fa-envelope"></i></div>
        <div>
            <div class="db-stat-num">
                {{ $stats['pesan_baru'] }}
                @if($stats['pesan_baru'] > 0)
                <span style="font-size:0.65rem;background:#fee2e2;color:#dc2626;padding:2px 7px;border-radius:50px;font-weight:700;vertical-align:middle;">Baru</span>
                @endif
            </div>
            <div class="db-stat-label">Pesan Masuk</div>
        </div>
    </a>
</div>

{{-- Bottom: Messages + Sidebar --}}
<div class="db-bottom">

    {{-- Left: Pesan Terbaru + Publikasi --}}
    <div style="display:flex;flex-direction:column;gap:24px;">

        {{-- Pesan Terbaru --}}
        <div class="db-panel">
            <div class="db-panel-head">
                <h3><i class="fas fa-envelope" style="color:#1a6fc4;"></i> Pesan Terbaru</h3>
                <a href="{{ route('admin.kontak.index') }}">Lihat Semua &rarr;</a>
            </div>
            @if($pesan_terbaru->isEmpty())
            <div class="db-msg-empty">
                <i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                Belum ada pesan masuk.
            </div>
            @else
            <div class="db-msg-list">
                @foreach($pesan_terbaru as $p)
                <a href="{{ route('admin.kontak.show', $p) }}" style="text-decoration:none;">
                    <div class="db-msg-item">
                        <div class="db-msg-avatar {{ !$p->sudah_dibaca ? 'unread' : '' }}">
                            {{ strtoupper(substr($p->nama, 0, 1)) }}
                        </div>
                        <div class="db-msg-info">
                            <div class="db-msg-name">{{ $p->nama }}</div>
                            <div class="db-msg-subj">{{ Str::limit($p->subjek, 50) }}</div>
                        </div>
                        <div class="db-msg-meta">
                            {{ $p->created_at->diffForHumans() }}
                            @if(!$p->sudah_dibaca)
                            <div class="db-unread-dot" style="margin:4px 0 0 auto;"></div>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Publikasi Terbaru --}}
        <div class="db-panel">
            <div class="db-panel-head">
                <h3><i class="fas fa-newspaper" style="color:#d97706;"></i> Publikasi Terbaru</h3>
                <a href="{{ route('admin.publikasi.index') }}">Lihat Semua &rarr;</a>
            </div>
            @if($publikasi_terbaru->isEmpty())
            <div class="db-msg-empty">Belum ada publikasi.</div>
            @else
            <div class="db-pub-list">
                @foreach($publikasi_terbaru as $i => $pub)
                <div class="db-pub-item">
                    <div class="db-pub-num">{{ $i + 1 }}</div>
                    <div>
                        <div class="db-pub-title">{{ $pub->judul }}</div>
                        <div class="db-pub-date"><i class="fas fa-calendar-alt"></i> {{ $pub->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>

    {{-- Right: Quick Actions + Website Info --}}
    <div style="display:flex;flex-direction:column;gap:24px;">

        {{-- Quick Actions --}}
        <div class="db-panel">
            <div class="db-panel-head">
                <h3><i class="fas fa-bolt" style="color:#f59e0b;"></i> Aksi Cepat</h3>
            </div>
            <div class="db-quick">
                <a href="{{ route('admin.layanan.create') }}" class="db-quick-btn">
                    <i class="fas fa-plus-circle"></i> Tambah Layanan
                </a>
                <a href="{{ route('admin.pengalaman.create') }}" class="db-quick-btn">
                    <i class="fas fa-plus-circle"></i> Tambah Pengalaman
                </a>
                <a href="{{ route('admin.publikasi.create') }}" class="db-quick-btn">
                    <i class="fas fa-plus-circle"></i> Tambah Publikasi
                </a>
                <a href="{{ route('admin.tim-organisasi.create') }}" class="db-quick-btn">
                    <i class="fas fa-plus-circle"></i> Tambah Tim Organisasi
                </a>
                <a href="{{ route('admin.galeri-slider.create') }}" class="db-quick-btn">
                    <i class="fas fa-plus-circle"></i> Tambah Tim Admin
                </a>
                <a href="{{ route('admin.testimoni.create') }}" class="db-quick-btn">
                    <i class="fas fa-plus-circle"></i> Tambah Testimoni
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="db-quick-btn" style="background:linear-gradient(135deg,#0d2b5e,#1a6fc4);color:#fff;border-color:transparent;">
                    <i class="fas fa-edit"></i> Edit Profil Lembaga
                </a>
            </div>
        </div>

        {{-- Website Info --}}
        <div class="db-panel">
            <div class="db-panel-head">
                <h3><i class="fas fa-globe" style="color:#0d9488;"></i> Info Website</h3>
            </div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.83rem;">
                    <span style="color:#64748b;font-weight:600;">Status</span>
                    <span style="background:#dcfce7;color:#16a34a;padding:3px 12px;border-radius:50px;font-weight:700;font-size:0.75rem;">
                        <i class="fas fa-circle" style="font-size:0.5rem;"></i> Online
                    </span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.83rem;">
                    <span style="color:#64748b;font-weight:600;">Framework</span>
                    <span style="font-weight:700;color:#0d2b5e;">Laravel {{ app()->version() }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.83rem;">
                    <span style="color:#64748b;font-weight:600;">Environment</span>
                    <span style="font-weight:700;color:#0d2b5e;">{{ ucfirst(app()->environment()) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.83rem;">
                    <span style="color:#64748b;font-weight:600;">Total Pesan</span>
                    <span style="font-weight:700;color:#0d2b5e;">{{ $stats['kontaks'] }}</span>
                </div>
                <hr style="border:none;border-top:1px solid #f1f5f9;margin:4px 0;">
                <a href="{{ route('beranda') }}" target="_blank"
                    style="display:flex;align-items:center;justify-content:center;gap:8px;padding:10px;background:#f1f5f9;border-radius:10px;color:#1a6fc4;font-weight:700;font-size:0.83rem;text-decoration:none;transition:background 0.2s;">
                    <i class="fas fa-external-link-alt"></i> Buka Website Publik
                </a>
            </div>
        </div>

    </div>
</div>
@endif {{-- end admin role --}}

@endsection

@push('scripts')
<script>
// Live clock
function updateClock() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    const el = document.getElementById('db-clock');
    if (el) el.textContent = h + ':' + m + ':' + s;
}
updateClock();
setInterval(updateClock, 1000);
</script>
@endpush
