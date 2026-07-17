@extends('layouts.admin')
@section('title', 'Pengaturan Website')

@push('styles')
<style>
.setting-tabs {
    display: flex;
    gap: 2px;
    margin-bottom: 28px;
    border-bottom: 2px solid #e2e8f0;
    overflow-x: auto;
    scrollbar-width: none;
}
.setting-tabs::-webkit-scrollbar { display: none; }
.stab {
    background: transparent;
    border: none;
    padding: 11px 18px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    white-space: nowrap;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 7px;
}
.stab:hover { color: #1a6fc4; background: #f8fafc; border-radius: 8px 8px 0 0; }
.stab.active { color: #1a6fc4; border-bottom-color: #1a6fc4; }
.stab-pane { display: none; animation: fadeIn 0.22s ease; }
.stab-pane.active { display: block; }
@keyframes fadeIn { from { opacity:0; transform:translateY(4px); } to { opacity:1; transform:translateY(0); } }

.setting-section {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 16px;
    padding: 26px 30px;
    margin-bottom: 20px;
}
.setting-section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.setting-icon {
    width: 42px; height: 42px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.setting-section-title h3 { font-size:1rem;font-weight:800;color:#0d2b5e;margin:0 0 3px; }
.setting-section-title p  { font-size:0.78rem;color:#94a3b8;margin:0; }

/* Maintenance toggle */
.maintenance-toggle-box {
    display:flex;align-items:center;justify-content:space-between;
    border-radius:12px;padding:18px 22px;margin-bottom:22px;border:1px solid;transition:all 0.3s;
}
.sw-label { position:relative;display:inline-block;width:56px;height:30px;flex-shrink:0;cursor:pointer; }
.sw-label input { opacity:0;width:0;height:0; }
.sw-track { position:absolute;inset:0;border-radius:30px;transition:0.3s; }
.sw-thumb { position:absolute;top:4px;width:22px;height:22px;border-radius:50%;background:#fff;transition:0.3s;box-shadow:0 2px 6px rgba(0,0,0,0.2); }

/* Upload area */
.upload-area {
    border: 2px dashed #cbd5e1;border-radius:10px;padding:22px 20px;text-align:center;
    cursor:pointer;transition:all 0.2s;background:#fafbfc;position:relative;
}
.upload-area:hover { border-color:#1a6fc4;background:rgba(26,111,196,0.03); }
.upload-area input[type=file] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%; }
.upload-area i { font-size:1.8rem;color:#94a3b8;margin-bottom:10px;display:block; }

/* Social icon preview */
.social-preview { display:flex;flex-wrap:wrap;gap:8px;margin-top:12px; }
.social-preview a {
    display:inline-flex;align-items:center;justify-content:center;
    width:36px;height:36px;border-radius:50%;font-size:0.9rem;
    transition:transform 0.2s;text-decoration:none;
}
.social-preview a:hover { transform:scale(1.12); }
</style>
@endpush

@section('content')
<div class="admin-page-header">
    <h1><i class="fas fa-cog" style="color:#1a6fc4;margin-right:10px;"></i>Pengaturan Website</h1>
</div>

@if(session('success'))
<div style="background:#dcfce7;border:1px solid #86efac;color:#16a34a;padding:14px 18px;border-radius:10px;margin-bottom:24px;display:flex;align-items:center;gap:10px;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="setting-tabs">
    <button class="stab active" onclick="showTab('umum',this)"><i class="fas fa-globe"></i> Umum</button>
    <button class="stab" onclick="showTab('kontak',this)"><i class="fas fa-address-book"></i> Kontak & Peta</button>
    <button class="stab" onclick="showTab('logo',this)"><i class="fas fa-palette"></i> Logo & Favicon</button>
    <button class="stab" onclick="showTab('sosmed',this)"><i class="fas fa-share-alt"></i> Media Sosial</button>
    <button class="stab" onclick="showTab('footer',this)"><i class="fas fa-layer-group"></i> Footer</button>
    <button class="stab" onclick="showTab('journals',this)"><i class="fas fa-book-open"></i> Journals</button>
    <button class="stab" onclick="showTab('maintenance',this)">
        <i class="fas fa-tools"></i> Maintenance
        @if(isset($profile) && $profile->maintenance_mode)
            <span style="background:#fef3c7;color:#d97706;font-size:0.62rem;font-weight:700;padding:2px 7px;border-radius:50px;border:1px solid #fcd34d;">AKTIF</span>
        @endif
    </button>
</div>

<form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    {{-- ══ TAB: UMUM ══════════════════════════════════════════ --}}
    <div class="stab-pane active" id="pane-umum">
        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon" style="background:#e8f0fb;"><i class="fas fa-building" style="color:#1a6fc4;"></i></div>
                <div><h3>Identitas Lembaga</h3><p>Nama, singkatan, dan tagline yang tampil di seluruh website</p></div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap Lembaga</label>
                    <input type="text" name="nama_lembaga" class="form-control @error('nama_lembaga') is-invalid @enderror"
                        value="{{ old('nama_lembaga', $profile->nama_lembaga ?? '') }}"
                        placeholder="Lembaga Pengkajian dan Pengembangan...">
                    @error('nama_lembaga')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Singkatan / Akronim</label>
                    <input type="text" name="singkatan" class="form-control"
                        value="{{ old('singkatan', $profile->singkatan ?? '') }}"
                        placeholder="LPPSP">
                    <small style="color:#64748b;">Tampil di header, tab browser, dan login admin.</small>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Tagline / Judul Hero Beranda</label>
                <input type="text" name="tagline" class="form-control"
                    value="{{ old('tagline', $profile->tagline ?? '') }}"
                    placeholder="Mitra Profesional dalam Pengkajian Pembangunan Daerah">
                <small style="color:#64748b;">Gunakan &lt;span&gt;teks&lt;/span&gt; untuk warna biru pada kata tertentu.</small>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="deskripsi_singkat" class="form-control" rows="3"
                    placeholder="Deskripsi 1–2 kalimat untuk SEO dan tampilan hero...">{{ old('deskripsi_singkat', $profile->deskripsi_singkat ?? '') }}</textarea>
            </div>
        </div>
        <div><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button></div>
    </div>

    {{-- ══ TAB: KONTAK & PETA ═══════════════════════════════════ --}}
    <div class="stab-pane" id="pane-kontak">
        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon" style="background:#f0fdf4;"><i class="fas fa-map-marker-alt" style="color:#16a34a;"></i></div>
                <div><h3>Kontak & Lokasi</h3><p>Ditampilkan di footer dan halaman Kontak</p></div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-map-marker-alt" style="color:#dc2626;margin-right:5px;"></i>Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3"
                    placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota, Provinsi">{{ old('alamat', $profile->alamat ?? '') }}</textarea>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-phone" style="color:#16a34a;margin-right:5px;"></i>Telepon / Fax</label>
                    <input type="text" name="telepon" class="form-control"
                        value="{{ old('telepon', $profile->telepon ?? '') }}"
                        placeholder="+6224-123456">
                    <small style="color:#64748b;">Bisa beberapa nomor, pisahkan dengan baris baru.</small>
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-envelope" style="color:#1a6fc4;margin-right:5px;"></i>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $profile->email ?? '') }}"
                        placeholder="info@lembaga.or.id">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-globe" style="color:#7c3aed;margin-right:5px;"></i>Website Eksternal</label>
                <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                    value="{{ old('website', $profile->website ?? '') }}"
                    placeholder="https://www.lembaga.or.id">
                @error('website')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon" style="background:#fef3c7;"><i class="fas fa-map" style="color:#d97706;"></i></div>
                <div><h3>Peta Lokasi (Google Maps)</h3><p>Tampil di footer website</p></div>
            </div>
            <div class="form-group">
                <label class="form-label">Google Maps Embed Code</label>
                <textarea name="maps_embed" class="form-control" rows="5"
                    placeholder="&lt;iframe src=&quot;https://www.google.com/maps/embed?...&quot;&gt;&lt;/iframe&gt;">{{ old('maps_embed', $profile->maps_embed ?? '') }}</textarea>
                <small style="color:#64748b;margin-top:5px;display:block;">
                    <i class="fas fa-info-circle"></i> Buka Google Maps → Bagikan → Sematkan Peta → Salin HTML
                </small>
            </div>
        </div>
        <div><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button></div>
    </div>

    {{-- ══ TAB: LOGO & FAVICON ══════════════════════════════════ --}}
    <div class="stab-pane" id="pane-logo">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

            {{-- Logo --}}
            <div class="setting-section">
                <div class="setting-section-title">
                    <div class="setting-icon" style="background:#e8f0fb;"><i class="fas fa-image" style="color:#1a6fc4;"></i></div>
                    <div><h3>Logo Lembaga</h3><p>Tampil di navbar dan footer</p></div>
                </div>
                @if(isset($profile) && $profile->logo)
                <div style="text-align:center;margin-bottom:16px;padding:16px;background:#f8fafc;border:1px dashed #cbd5e1;border-radius:10px;">
                    <img src="{{ Storage::url($profile->logo) }}" alt="Logo" style="max-height:80px;max-width:100%;object-fit:contain;">
                    <p style="font-size:0.75rem;color:#94a3b8;margin:8px 0 0;">Logo saat ini</p>
                </div>
                @endif
                <div class="upload-area" id="logoUploadArea">
                    <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml,image/webp"
                        onchange="previewImg(this,'prevLogo','logoUploadArea')">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <img id="prevLogo" style="display:none;max-height:80px;max-width:100%;object-fit:contain;margin:0 auto 10px;display:none;">
                    <p><strong>Klik untuk upload logo</strong></p>
                    <p style="font-size:0.78rem;color:#94a3b8;margin-top:6px;">PNG transparan atau SVG. Maks 2MB.</p>
                </div>
            </div>

            {{-- Favicon --}}
            <div class="setting-section">
                <div class="setting-section-title">
                    <div class="setting-icon" style="background:#fdf4ff;"><i class="fas fa-globe" style="color:#9333ea;"></i></div>
                    <div><h3>Favicon</h3><p>Ikon kecil di tab browser</p></div>
                </div>
                @if(isset($profile) && $profile->favicon)
                <div style="text-align:center;margin-bottom:16px;padding:16px;background:#f8fafc;border:1px dashed #cbd5e1;border-radius:10px;">
                    <img src="{{ Storage::url($profile->favicon) }}" alt="Favicon" style="width:48px;height:48px;object-fit:contain;">
                    <p style="font-size:0.75rem;color:#94a3b8;margin:8px 0 0;">Favicon saat ini</p>
                </div>
                @endif
                <div class="upload-area" id="faviconUploadArea">
                    <input type="file" name="favicon" accept="image/png,image/x-icon,image/jpeg"
                        onchange="previewImg(this,'prevFavicon','faviconUploadArea')">
                    <i class="fas fa-star"></i>
                    <img id="prevFavicon" style="display:none;width:64px;height:64px;object-fit:contain;margin:0 auto 10px;">
                    <p><strong>Klik untuk upload favicon</strong></p>
                    <p style="font-size:0.78rem;color:#94a3b8;margin-top:6px;">Rasio 1:1 (kotak). PNG atau ICO. Maks 512KB.</p>
                </div>
            </div>
        </div>
        <div><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button></div>
    </div>

    {{-- ══ TAB: MEDIA SOSIAL ════════════════════════════════════ --}}
    <div class="stab-pane" id="pane-sosmed">
        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon" style="background:#fdf4ff;"><i class="fas fa-share-alt" style="color:#9333ea;"></i></div>
                <div><h3>Akun Media Sosial</h3><p>Semua opsional. Yang diisi akan tampil sebagai ikon di footer dan halaman Kontak.</p></div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-facebook" style="color:#1d4ed8;margin-right:6px;"></i>Facebook</label>
                    <input type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror"
                        value="{{ old('facebook', $profile->facebook ?? '') }}" placeholder="https://facebook.com/namahalaman">
                    @error('facebook')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-instagram" style="color:#e1306c;margin-right:6px;"></i>Instagram</label>
                    <input type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror"
                        value="{{ old('instagram', $profile->instagram ?? '') }}" placeholder="https://instagram.com/namaakun">
                    @error('instagram')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-x-twitter" style="color:#000;margin-right:6px;"></i>Twitter / X</label>
                    <input type="url" name="twitter" class="form-control @error('twitter') is-invalid @enderror"
                        value="{{ old('twitter', $profile->twitter ?? '') }}" placeholder="https://x.com/namaakun">
                    @error('twitter')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-youtube" style="color:#dc2626;margin-right:6px;"></i>YouTube</label>
                    <input type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror"
                        value="{{ old('youtube', $profile->youtube ?? '') }}" placeholder="https://youtube.com/@namakanal">
                    @error('youtube')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-tiktok" style="color:#010101;margin-right:6px;"></i>TikTok</label>
                    <input type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror"
                        value="{{ old('tiktok', $profile->tiktok ?? '') }}" placeholder="https://tiktok.com/@namaakun">
                    @error('tiktok')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-linkedin" style="color:#0a66c2;margin-right:6px;"></i>LinkedIn</label>
                    <input type="url" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror"
                        value="{{ old('linkedin', $profile->linkedin ?? '') }}" placeholder="https://linkedin.com/company/namaorg">
                    @error('linkedin')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-whatsapp" style="color:#16a34a;margin-right:6px;"></i>WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control"
                        value="{{ old('whatsapp', $profile->whatsapp ?? '') }}" placeholder="628123456789">
                    <small style="color:#64748b;">Format internasional tanpa + (62xxx) → auto-link wa.me</small>
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-telegram" style="color:#0088cc;margin-right:6px;"></i>Telegram</label>
                    <input type="text" name="telegram" class="form-control"
                        value="{{ old('telegram', $profile->telegram ?? '') }}" placeholder="https://t.me/namaakun">
                    @error('telegram')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-at" style="color:#111;margin-right:6px;"></i>Threads</label>
                <input type="url" name="threads" class="form-control @error('threads') is-invalid @enderror"
                    value="{{ old('threads', $profile->threads ?? '') }}" placeholder="https://threads.net/@namaakun">
                @error('threads')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            {{-- Preview ikon aktif --}}
            @php
                $activeSosmed = collect([
                    ['url' => $profile->facebook ?? null,  'icon' => 'fab fa-facebook-f',  'bg' => '#1d4ed8', 'label' => 'Facebook'],
                    ['url' => $profile->instagram ?? null, 'icon' => 'fab fa-instagram',   'bg' => '#e1306c', 'label' => 'Instagram'],
                    ['url' => $profile->twitter ?? null,   'icon' => 'fab fa-x-twitter',   'bg' => '#000',    'label' => 'X/Twitter'],
                    ['url' => $profile->youtube ?? null,   'icon' => 'fab fa-youtube',     'bg' => '#dc2626', 'label' => 'YouTube'],
                    ['url' => $profile->tiktok ?? null,    'icon' => 'fab fa-tiktok',      'bg' => '#010101', 'label' => 'TikTok'],
                    ['url' => $profile->linkedin ?? null,  'icon' => 'fab fa-linkedin-in', 'bg' => '#0a66c2', 'label' => 'LinkedIn'],
                    ['url' => ($profile->whatsapp ?? null) ? 'https://wa.me/'.preg_replace('/[^0-9]/','',$profile->whatsapp) : null,
                                                             'icon' => 'fab fa-whatsapp',   'bg' => '#16a34a', 'label' => 'WhatsApp'],
                    ['url' => $profile->telegram ?? null,  'icon' => 'fab fa-telegram',    'bg' => '#0088cc', 'label' => 'Telegram'],
                    ['url' => $profile->threads ?? null,   'icon' => 'fas fa-at',          'bg' => '#111',    'label' => 'Threads'],
                ])->filter(fn($s) => !empty($s['url']));
            @endphp
            @if($activeSosmed->count())
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px 18px;margin-top:8px;">
                <p style="font-size:0.78rem;font-weight:700;color:#64748b;margin:0 0 10px;"><i class="fas fa-eye"></i> Preview ikon yang aktif di footer:</p>
                <div class="social-preview">
                    @foreach($activeSosmed as $s)
                    <a href="{{ $s['url'] }}" target="_blank" title="{{ $s['label'] }}"
                        style="background:{{ $s['bg'] }};color:#fff;width:36px;height:36px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:0.85rem;">
                        <i class="{{ $s['icon'] }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div style="margin-top:8px;"><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button></div>
    </div>

    {{-- ══ TAB: FOOTER ═══════════════════════════════════════════ --}}
    <div class="stab-pane" id="pane-footer">
        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon" style="background:#e8f0fb;"><i class="fas fa-layer-group" style="color:#1a6fc4;"></i></div>
                <div><h3>Konten Footer</h3><p>Teks yang ditampilkan di bagian bawah setiap halaman website</p></div>
            </div>

            <div class="form-group">
                <label class="form-label">Slogan / Deskripsi Footer</label>
                <textarea name="footer_slogan" class="form-control" rows="3"
                    placeholder="Contoh: Mitra terpercaya dalam riset dan konsultasi pembangunan daerah.">{{ old('footer_slogan', $profile->footer_slogan ?? '') }}</textarea>
                <small style="color:#64748b;margin-top:5px;display:block;">
                    Tampil di kolom kiri footer, di bawah logo/nama lembaga.
                    Kosongkan untuk menggunakan <em>Deskripsi Singkat</em> dari tab Umum.
                </small>
            </div>

            <div class="form-group">
                <label class="form-label">Teks Copyright</label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.85rem;">© {{ date('Y') }}</span>
                    <input type="text" name="footer_copyright" class="form-control"
                        style="padding-left:56px;"
                        value="{{ old('footer_copyright', $profile->footer_copyright ?? '') }}"
                        placeholder="{{ $profile->singkatan ?? 'LPPSP' }}. Semua hak dilindungi.">
                </div>
                <small style="color:#64748b;margin-top:5px;display:block;">Tahun akan ditambahkan otomatis di depan teks ini.</small>
            </div>

            {{-- Preview footer card --}}
            <div style="background:linear-gradient(135deg,#0d2b5e,#1a4a9e);border-radius:12px;padding:20px 24px;margin-top:8px;">
                <p style="font-size:0.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,0.4);margin:0 0 6px;">PREVIEW FOOTER</p>
                @if(isset($profile) && $profile->logo)
                    <img src="{{ Storage::url($profile->logo) }}" style="height:36px;object-fit:contain;margin-bottom:10px;filter:brightness(0) invert(1);">
                @else
                    <p style="font-size:1.1rem;font-weight:800;color:#fff;margin:0 0 6px;">{{ $profile->singkatan ?? 'LPPSP' }}</p>
                @endif
                <p style="font-size:0.83rem;color:rgba(255,255,255,0.65);line-height:1.6;margin:0 0 14px;max-width:300px;">
                    {{ $profile->footer_slogan ?? $profile->deskripsi_singkat ?? 'Slogan / deskripsi footer akan tampil di sini.' }}
                </p>
                <p style="font-size:0.75rem;color:rgba(255,255,255,0.35);margin:0;border-top:1px solid rgba(255,255,255,0.1);padding-top:10px;">
                    © {{ date('Y') }} {{ $profile->footer_copyright ?? ($profile->singkatan ?? 'LPPSP') . '. Semua hak dilindungi.' }}
                </p>
            </div>
        </div>
        <div><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button></div>
    </div>

    {{-- ══ TAB: JOURNALS ══════════════════════════════════════ --}}
    <div class="stab-pane" id="pane-journals">
        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon" style="background:#ede9fe;"><i class="fas fa-book-open" style="color:#7c3aed;"></i></div>
                <div><h3>{{ $profile->singkatan ?? 'LPPSP' }} Journals</h3><p>Gambar promosi dan link jurnal ilmiah {{ $profile->singkatan ?? 'LPPSP' }} yang ditampilkan di halaman utama</p></div>
            </div>
            <div class="form-group">
                <label class="form-label">Gambar Promosi Jurnal</label>
                <input type="file" name="journals_gambar" class="form-control" accept="image/*"
                    onchange="previewImg(this,'prevJournals')">
                @if($profile && $profile->journals_gambar)
                <img id="prevJournals" src="{{ Storage::url($profile->journals_gambar) }}"
                    style="max-height:200px;margin-top:10px;border-radius:8px;border:1px solid #e2e8f0;">
                @else
                <img id="prevJournals" style="display:none;max-height:200px;margin-top:10px;border-radius:8px;border:1px solid #e2e8f0;">
                @endif
                <small style="color:#64748b;margin-top:6px;display:block;">Upload screenshot atau banner jurnal. Maks 3MB.</small>
            </div>
            <div class="form-group">
                <label class="form-label">URL Link Jurnal</label>
                <input type="url" name="journals_url" class="form-control"
                    value="{{ old('journals_url', $profile->journals_url ?? 'https://journal.lppspsemarang.org/index.php/Jarvic') }}"
                    placeholder="https://journal.lppspsemarang.org/...">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat <span style="font-weight:400;color:#94a3b8;">(opsional)</span></label>
                <textarea name="journals_deskripsi" class="form-control" rows="3"
                    placeholder="Jurnal ilmiah LPPSP yang mempublikasikan hasil kajian dan penelitian kebijakan publik...">{{ old('journals_deskripsi', $profile->journals_deskripsi ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </div>

    {{-- ══ TAB: MAINTENANCE ════════════════════════════════════ --}}
    <div class="stab-pane" id="pane-maintenance">
        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon" style="background:#fef3c7;"><i class="fas fa-tools" style="color:#d97706;"></i></div>
                <div><h3>Mode Maintenance</h3><p>Saat aktif, pengunjung tanpa login akan melihat halaman pemeliharaan</p></div>
            </div>

            <div class="maintenance-toggle-box" id="maintenanceBox"
                style="background:{{ isset($profile) && $profile->maintenance_mode ? '#fef3c7' : '#f8fafc' }};border-color:{{ isset($profile) && $profile->maintenance_mode ? '#fcd34d' : '#e2e8f0' }};">
                <div>
                    <p style="font-weight:700;color:#0d2b5e;margin:0 0 4px;font-size:0.95rem;">Status Saat Ini</p>
                    <p style="font-size:0.82rem;margin:0;" id="maintenanceStatusText">
                        @if(isset($profile) && $profile->maintenance_mode)
                            <span style="color:#d97706;font-weight:600;"><i class="fas fa-exclamation-triangle"></i> Website sedang dalam mode maintenance</span>
                        @else
                            <span style="color:#16a34a;font-weight:600;"><i class="fas fa-check-circle"></i> Website aktif & dapat diakses publik</span>
                        @endif
                    </p>
                </div>
                <label class="sw-label">
                    <input type="checkbox" name="maintenance_mode" value="1" id="maintenanceToggle"
                        {{ isset($profile) && $profile->maintenance_mode ? 'checked' : '' }}>
                    <span class="sw-track" id="swTrack"
                        style="background:{{ isset($profile) && $profile->maintenance_mode ? '#d97706' : '#cbd5e1' }};"></span>
                    <span class="sw-thumb" id="swThumb"
                        style="left:{{ isset($profile) && $profile->maintenance_mode ? '30px' : '4px' }};"></span>
                </label>
            </div>

            <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:14px 18px;margin-bottom:22px;display:flex;gap:12px;align-items:flex-start;">
                <i class="fas fa-exclamation-triangle" style="color:#ea580c;margin-top:2px;flex-shrink:0;"></i>
                <div style="font-size:0.82rem;color:#9a3412;line-height:1.6;">
                    <strong>Perhatian:</strong> Saat maintenance aktif, seluruh halaman publik tidak dapat diakses pengunjung.
                    Admin yang sudah login tetap dapat mengakses website secara normal.
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Pesan untuk Pengunjung</label>
                <textarea name="maintenance_pesan" class="form-control" rows="4"
                    placeholder="Website sedang dalam pembaruan sistem. Kami akan kembali dalam beberapa saat. Mohon maaf atas ketidaknyamanannya.">{{ old('maintenance_pesan', $profile->maintenance_pesan ?? '') }}</textarea>
                <small style="color:#64748b;margin-top:5px;display:block;">Kosongkan untuk menggunakan pesan default.</small>
            </div>

            <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('beranda') }}" target="_blank" class="btn btn-outline"><i class="fas fa-external-link-alt"></i> Lihat Website</a>
                @if(isset($profile) && $profile->maintenance_mode)
                    <span style="display:inline-flex;align-items:center;gap:6px;background:#fef3c7;color:#d97706;font-size:0.8rem;font-weight:700;padding:8px 16px;border-radius:8px;border:1px solid #fcd34d;">
                        <i class="fas fa-exclamation-triangle"></i> Maintenance AKTIF
                    </span>
                @endif
            </div>
        </div>
    </div>

</form>
@endsection

@push('scripts')
<script>
function showTab(name, btn) {
    document.querySelectorAll('.stab').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.stab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('pane-' + name).classList.add('active');
    history.replaceState(null,'','#'+name);
}

function previewImg(input, imgId, areaId) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(imgId);
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}

// Maintenance toggle live UI
const toggle = document.getElementById('maintenanceToggle');
const track  = document.getElementById('swTrack');
const thumb  = document.getElementById('swThumb');
const box    = document.getElementById('maintenanceBox');
const text   = document.getElementById('maintenanceStatusText');
toggle.addEventListener('change', function () {
    if (this.checked) {
        track.style.background = '#d97706'; thumb.style.left = '30px';
        box.style.background = '#fef3c7'; box.style.borderColor = '#fcd34d';
        text.innerHTML = '<span style="color:#d97706;font-weight:600;"><i class="fas fa-exclamation-triangle"></i> Website akan dalam mode maintenance</span>';
    } else {
        track.style.background = '#cbd5e1'; thumb.style.left = '4px';
        box.style.background = '#f8fafc'; box.style.borderColor = '#e2e8f0';
        text.innerHTML = '<span style="color:#16a34a;font-weight:600;"><i class="fas fa-check-circle"></i> Website aktif & dapat diakses publik</span>';
    }
});

// Restore active tab from hash
const hash = window.location.hash.replace('#','');
if (['umum','kontak','logo','sosmed','footer','journals','maintenance'].includes(hash)) {
    const btn = document.querySelector(`.stab[onclick*="${hash}"]`);
    if (btn) showTab(hash, btn);
}
</script>
@endpush
