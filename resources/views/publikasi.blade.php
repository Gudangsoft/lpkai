@extends('layouts.app')
@section('title', 'Publikasi')

@push('styles')
<style>
    /* ── Original layout ──────────────────────── */
    .tk-container {
        max-width: 1200px;
        margin: 32px auto;
        padding: 0 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
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
    .pub-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    .pub-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        display: flex;
        align-items: flex-start;
        gap: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }
    .pub-card:hover { transform: translateY(-5px); box-shadow: var(--shadow); }
    .pub-logo-box {
        width: 100px; height: 100px;
        background: rgba(26, 111, 196, 0.15);
        color: var(--primary); border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem; flex-shrink: 0;
    }
    .pub-content { display: flex; flex-direction: column; gap: 12px; flex-grow: 1; }
    .pub-card-title { color: var(--primary); font-size: 1.2rem; font-weight: 800; margin: 0; }
    .pub-card-desc { color: var(--text); font-size: 0.95rem; line-height: 1.6; margin: 0; }
    .pub-btn {
        display: inline-block; background: var(--primary); color: var(--white);
        font-weight: 700; font-size: 0.9rem; padding: 8px 20px;
        border-radius: 50px; text-decoration: none; transition: var(--transition);
        align-self: flex-start; margin-top: 4px;
    }
    .pub-btn:hover { background: var(--gold); color: var(--primary); }

    /* ── BPS-style layout (Buku only) ───────────── */
    .buku-hero {
        background: linear-gradient(135deg, #0d2b5e 0%, #1a4a9e 60%, #1a6fc4 100%);
        padding: 36px 0 44px; position: relative; overflow: hidden;
    }
    .buku-hero::before {
        content:''; position:absolute; top:-80px; right:-80px;
        width:300px; height:300px; border-radius:50%;
        background:rgba(255,255,255,0.05);
    }
    .buku-hero-inner {
        max-width:1200px; margin:0 auto; padding:0 24px;
        position:relative; z-index:1;
    }
    .buku-hero h1 { font-size:1.9rem; font-weight:800; color:#fff; margin-bottom:6px; }
    .buku-hero p  { font-size:0.92rem; color:rgba(255,255,255,0.75); margin-bottom:22px; }
    .buku-search-bar {
        display:flex; max-width:520px;
        background:#fff; border-radius:10px;
        box-shadow:0 4px 20px rgba(0,0,0,0.15); overflow:hidden;
    }
    .buku-search-bar input {
        flex:1; padding:12px 18px; border:none; outline:none;
        font-size:0.93rem; color:#0d2b5e;
    }
    .buku-search-bar button {
        background:#f59e0b; color:#fff; border:none; padding:0 20px;
        font-weight:700; font-size:0.88rem; cursor:pointer;
        display:flex; align-items:center; gap:6px; transition:background 0.2s;
    }
    .buku-search-bar button:hover { background:#d97706; }

    .buku-body {
        max-width:1200px; margin:28px auto 60px; padding:0 24px;
        display:grid; grid-template-columns:230px 1fr; gap:28px;
        align-items:flex-start;
    }

    /* Sidebar */
    .buku-sidebar { display:flex; flex-direction:column; gap:14px; position:sticky; top:16px; }
    .buku-sidebar-card {
        background:#fff; border-radius:12px; border:1px solid #e2e8f0;
        overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.04);
    }
    .buku-sidebar-head {
        background:#0d2b5e; color:#fff; padding:11px 16px;
        font-size:0.78rem; font-weight:700; text-transform:uppercase;
        letter-spacing:0.5px; display:flex; align-items:center; gap:8px;
    }
    .buku-sidebar-body { padding:16px; }
    .buku-stat {
        display:flex; align-items:center; gap:10px;
        padding:10px 0; border-bottom:1px solid #f1f5f9;
    }
    .buku-stat:last-child { border-bottom:none; padding-bottom:0; }
    .buku-stat-icon {
        width:36px; height:36px; border-radius:8px; flex-shrink:0;
        background:linear-gradient(135deg,#eff6ff,#dbeafe);
        display:flex; align-items:center; justify-content:center;
        color:#1a4a9e; font-size:0.95rem;
    }
    .buku-stat-label { font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.3px; }
    .buku-stat-val   { font-size:1.05rem; font-weight:800; color:#0d2b5e; line-height:1; }
    .buku-back-link {
        display:flex; align-items:center; gap:8px; padding:11px 16px;
        font-size:0.83rem; font-weight:600; color:#475569;
        text-decoration:none; transition:background 0.15s;
    }
    .buku-back-link:hover { background:#f8fafc; color:#0d2b5e; }

    /* Book list */
    .buku-toolbar {
        display:flex; align-items:center; justify-content:space-between;
        margin-bottom:18px; padding-bottom:14px; border-bottom:2px solid #f1f5f9;
        flex-wrap:wrap; gap:10px;
    }
    .buku-toolbar-title {
        font-size:1.05rem; font-weight:800; color:#0d2b5e;
        display:flex; align-items:center; gap:10px;
    }
    .buku-toolbar-title .badge {
        background:linear-gradient(135deg,#1a4a9e,#1a6fc4);
        color:#fff; font-size:0.68rem; padding:3px 10px;
        border-radius:20px; font-weight:700;
    }
    .buku-list { display:flex; flex-direction:column; gap:14px; }
    .buku-item {
        background:#fff; border-radius:12px; border:1px solid #e2e8f0;
        padding:14px; display:flex; gap:18px;
        transition:all 0.2s; text-decoration:none;
        box-shadow:0 2px 6px rgba(0,0,0,0.04);
    }
    .buku-item:hover {
        transform:translateY(-3px);
        box-shadow:0 10px 28px rgba(13,43,94,0.1);
        border-color:#93c5fd;
    }
    .buku-item-cover {
        width:90px; flex-shrink:0; border-radius:8px; overflow:hidden;
        border:1px solid #e2e8f0; background:#f8fafc;
        display:flex; align-items:center; justify-content:center; min-height:120px;
    }
    .buku-item-cover img { width:100%; height:120px; object-fit:contain; display:block; padding:4px; }
    .buku-item-cover-placeholder {
        width:100%; height:120px;
        display:flex; align-items:center; justify-content:center;
        color:#93c5fd; font-size:1.8rem;
    }
    .buku-item-body { flex:1; display:flex; flex-direction:column; gap:7px; }
    .buku-item-title {
        font-size:0.97rem; font-weight:700; color:#0d2b5e; line-height:1.4; margin:0;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }
    .buku-item-desc {
        font-size:0.82rem; color:#64748b; line-height:1.6; margin:0;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }
    .buku-item-meta {
        display:flex; align-items:center; gap:14px;
        font-size:0.76rem; color:#94a3b8; margin-top:auto;
    }
    .buku-item-meta span { display:flex; align-items:center; gap:4px; }
    .buku-item-cta {
        display:inline-flex; align-items:center; gap:6px;
        background:linear-gradient(135deg,#0d2b5e,#1a6fc4);
        color:#fff; font-size:0.76rem; font-weight:700;
        padding:6px 13px; border-radius:7px; align-self:flex-start; margin-top:2px;
        transition:all 0.2s;
    }
    .buku-item-cta:hover { transform:translateX(3px); color:#fff; }
    .buku-empty {
        text-align:center; padding:56px 20px; color:#94a3b8;
        background:#fafafa; border-radius:12px; border:1px dashed #e2e8f0;
    }
    .buku-empty i { font-size:2.5rem; display:block; margin-bottom:12px; color:#cbd5e1; }

    @media (max-width:900px) {
        .buku-body { grid-template-columns:1fr; }
        .buku-sidebar { position:static; }
    }
    @media (max-width:768px) {
        .pub-grid { grid-template-columns:1fr; }
        .tk-top-section { padding:24px; }
        .pub-card { flex-direction:column; align-items:center; text-align:center; }
        .pub-btn { align-self:center; }
        .buku-item { flex-direction:column; }
        .buku-item-cover { width:100%; min-height:auto; }
        .buku-item-cover img { height:180px; }
    }
</style>
@endpush

@section('content')

@if($kategori === 'Buku')
{{-- ══ BUKU: BPS-style layout ══ --}}

<div class="buku-hero">
    <div class="buku-hero-inner">
        <h1><i class="fas fa-book" style="margin-right:10px;opacity:0.8;"></i>Buku LPPSP</h1>
        <p>Koleksi buku hasil kajian, penelitian, dan dokumentasi pengetahuan kelembagaan LPPSP.</p>
        <form method="GET" action="{{ route('publikasi') }}" class="buku-search-bar">
            <input type="hidden" name="kategori" value="Buku">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul buku...">
            <button type="submit"><i class="fas fa-search"></i> Cari</button>
        </form>
    </div>
</div>

<div class="buku-body" id="daftar-publikasi">

    {{-- Sidebar --}}
    <aside class="buku-sidebar">
        <div class="buku-sidebar-card">
            <div class="buku-sidebar-head"><i class="fas fa-info-circle"></i> Informasi</div>
            <div class="buku-sidebar-body">
                <div class="buku-stat">
                    <div class="buku-stat-icon"><i class="fas fa-book"></i></div>
                    <div>
                        <div class="buku-stat-label">Total Buku</div>
                        <div class="buku-stat-val">{{ $publikasis->total() }}</div>
                    </div>
                </div>
                <div class="buku-stat">
                    <div class="buku-stat-icon"><i class="fas fa-layer-group"></i></div>
                    <div>
                        <div class="buku-stat-label">Halaman</div>
                        <div class="buku-stat-val">{{ $publikasis->currentPage() }} / {{ $publikasis->lastPage() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="buku-sidebar-card">
            <a href="{{ route('publikasi') }}" class="buku-back-link">
                <i class="fas fa-arrow-left" style="color:#1a6fc4;"></i> Semua Publikasi
            </a>
        </div>
    </aside>

    {{-- Main --}}
    <div>
        <div class="buku-toolbar">
            <div class="buku-toolbar-title">
                <i class="fas fa-book" style="color:#1a6fc4;"></i> Buku
                <span class="badge">{{ $publikasis->total() }} buku</span>
            </div>
            @if(request('q'))
            <a href="{{ route('publikasi', ['kategori' => 'Buku']) }}" style="font-size:0.82rem;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:5px;">
                <i class="fas fa-times-circle"></i> Reset pencarian
            </a>
            @endif
        </div>

        @if($publikasis->isEmpty())
        <div class="buku-empty">
            <i class="fas fa-inbox"></i>
            <p style="font-size:1rem;font-weight:600;margin-bottom:4px;">Belum ada buku</p>
            <p style="font-size:0.85rem;">Coba kata kunci lain.</p>
        </div>
        @else
        <div class="buku-list">
            @foreach($publikasis as $p)
            <a href="{{ route('publikasi.show', $p) }}" class="buku-item">
                <div class="buku-item-cover">
                    @if($p->gambar)
                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}">
                    @else
                    <div class="buku-item-cover-placeholder"><i class="fas fa-book"></i></div>
                    @endif
                </div>
                <div class="buku-item-body">
                    <h3 class="buku-item-title">{{ $p->judul }}</h3>
                    @if($p->deskripsi)
                    <p class="buku-item-desc">{{ $p->deskripsi }}</p>
                    @endif
                    <div class="buku-item-meta">
                        @if($p->penulis)<span><i class="fas fa-user-edit"></i> {{ Str::limit($p->penulis, 30) }}</span>@endif
                        <span><i class="fas fa-calendar-alt"></i> {{ $p->tanggal_terbit ? $p->tanggal_terbit->format('Y') : $p->created_at->format('Y') }}</span>
                        @if($p->file_url)<span><i class="fas fa-file-pdf" style="color:#ef4444;"></i> Tersedia</span>@endif
                    </div>
                    <span class="buku-item-cta">Lihat Detail <i class="fas fa-arrow-right" style="font-size:0.68rem;"></i></span>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        @if($publikasis->hasPages())
        <div style="margin-top:28px;display:flex;justify-content:center;">
            {{ $publikasis->appends(request()->only(['kategori','q']))->links() }}
        </div>
        @endif
    </div>
</div>

@else
{{-- ══ TAMPILAN AWAL: Semua kategori lain ══ --}}

<div class="tk-container">

    <div class="tk-top-section">
        <h2 class="tk-box-title">Publikasi</h2>
        <p class="tk-top-desc">
            Publikasi LPPSP merupakan hasil kerjasama LPPSP dengan Klien dan Mitra dalam layanan pengkajian, pengembangan sumberdaya pembangunan, pemberdayaan masyarakat, dan penguatan tata kelola pemerintahan pada bidang sosial, bidang pembangunan daerah dan pemerintahan, bidang kemanusiaan, dan bidang keagamaan.
        </p>
    </div>

    @if($kategori === 'semua')
    <div class="pub-grid">
        <div class="pub-card">
            <div class="pub-logo-box"><i class="fas fa-book"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Buku</h3>
                <p class="pub-card-desc">Publikasi buku hasil kajian, pembelajaran, dan dokumentasi pengetahuan kelembagaan.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Buku']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>
        <div class="pub-card">
            <div class="pub-logo-box"><i class="fas fa-file-alt"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Artikel</h3>
                <p class="pub-card-desc">Artikel substantif mengenai isu pembangunan, tata kelola, dan pengembangan masyarakat.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Artikel']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>
        <div class="pub-card">
            <div class="pub-logo-box"><i class="fas fa-newspaper"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Berita Kegiatan</h3>
                <p class="pub-card-desc">Informasi kegiatan lembaga, pelatihan, pendampingan, dan kolaborasi LPPSP.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Berita Kegiatan']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>
        <div class="pub-card">
            <div class="pub-logo-box"><i class="fas fa-images"></i></div>
            <div class="pub-content">
                <h3 class="pub-card-title">Foto/Video Kegiatan</h3>
                <p class="pub-card-desc">Dokumentasi visual kegiatan, pelatihan, forum, dan proses pendampingan di lapangan.</p>
                <a href="{{ route('publikasi', ['kategori' => 'Foto/Video Kegiatan']) }}#daftar-publikasi" class="pub-btn">Lihat selengkapnya.....</a>
            </div>
        </div>
    </div>
    @endif

    @if($kategori !== 'semua')
    <div id="daftar-publikasi" style="margin-top:28px;border-top:1px solid var(--border);padding-top:40px;scroll-margin-top:80px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <h3 class="tk-box-title" style="margin:0;font-size:1.5rem;">Publikasi: {{ $kategori }}</h3>
            <a href="{{ route('publikasi') }}" style="color:var(--text-light);text-decoration:none;font-size:0.9rem;"><i class="fas fa-times-circle"></i> Reset Filter</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;">
            @forelse($publikasis as $p)
            <div style="background:var(--white);border-radius:var(--radius);overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-sm);display:flex;flex-direction:column;transition:var(--transition);">
                @if($p->gambar)
                <div style="width:100%;height:220px;background:#f8fafc;display:flex;align-items:center;justify-content:center;overflow:hidden;border-bottom:1px solid var(--border);">
                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" style="width:100%;height:100%;object-fit:cover;">
                </div>
                @else
                <div style="width:100%;height:220px;background:rgba(26,111,196,0.05);display:flex;align-items:center;justify-content:center;color:var(--primary);border-bottom:1px solid var(--border);">
                    <i class="fas {{ $p->kategori=='Artikel'?'fa-file-alt':($p->kategori=='Berita Kegiatan'?'fa-newspaper':'fa-images') }}" style="font-size:3rem;opacity:0.2;"></i>
                </div>
                @endif
                <div style="padding:24px;flex-grow:1;display:flex;flex-direction:column;">
                    <span style="font-size:0.75rem;font-weight:700;color:var(--primary);background:rgba(26,111,196,0.1);padding:4px 10px;border-radius:4px;align-self:flex-start;margin-bottom:16px;">{{ $p->kategori }}</span>
                    <h4 style="font-size:1.15rem;color:#0d2b5e;font-weight:800;margin:0 0 12px;line-height:1.4;">{{ Str::limit($p->judul, 70) }}</h4>
                    <p style="font-size:0.95rem;color:var(--text);margin:0 0 20px;line-height:1.6;flex-grow:1;">{{ Str::limit($p->deskripsi, 90) }}</p>
                    <a href="{{ route('publikasi.show', $p) }}" style="font-size:0.9rem;font-weight:700;color:var(--primary);text-decoration:none;display:flex;align-items:center;gap:8px;">Baca Detail <i class="fas fa-arrow-right" style="font-size:0.8em;"></i></a>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-light);background:#fafafa;border-radius:var(--radius);border:1px dashed var(--border);">
                Belum ada publikasi untuk kategori ini.
            </div>
            @endforelse
        </div>
        @if($publikasis->hasPages())
        <div style="margin-top:32px;">
            {{ $publikasis->appends(['kategori' => $kategori])->links() }}
        </div>
        @endif
    </div>
    @endif

</div>

@endif

@endsection
