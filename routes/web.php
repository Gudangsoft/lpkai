<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PengalamanController;
use App\Http\Controllers\KlienMitraController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\LayananAdminController;
use App\Http\Controllers\Admin\PengalamanAdminController;
use App\Http\Controllers\Admin\KlienMitraAdminController;
use App\Http\Controllers\Admin\TestimoniAdminController;
use App\Http\Controllers\Admin\PublikasiAdminController;
use App\Http\Controllers\Admin\KategoriPublikasiAdminController;
use App\Http\Controllers\Admin\KontakAdminController;
use App\Http\Controllers\Admin\TimOrganisasiAdminController;
use App\Http\Controllers\Admin\GaleriSliderAdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserProfileController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/tentang-kami', [TentangKamiController::class, 'index'])->name('tentang-kami');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/pengalaman', [PengalamanController::class, 'index'])->name('pengalaman');
Route::get('/pengalaman/{pengalaman}', [PengalamanController::class, 'show'])->name('pengalaman.show');
Route::get('/klien-mitra', [KlienMitraController::class, 'index'])->name('klien-mitra');
Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni');
Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi');
Route::get('/publikasi/{publikasi:slug}', [PublikasiController::class, 'show'])->name('publikasi.show');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// ─── Auth Routes ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', function () {
        return view('admin.auth.login');
    })->name('admin.login');

    Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    })->name('admin.login.post');
});

// ─── Admin Routes (protected) ─────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // User Profile
    Route::get('/user-profile', [UserProfileController::class, 'edit'])->name('user-profile.edit');
    Route::put('/user-profile', [UserProfileController::class, 'update'])->name('user-profile.update');


    // Layanan
    Route::resource('/layanan', LayananAdminController::class)->except(['show']);

    // Pengalaman
    Route::post('/pengalaman/import', [PengalamanAdminController::class, 'import'])->name('pengalaman.import');
    Route::get('/pengalaman/template', [PengalamanAdminController::class, 'template'])->name('pengalaman.template');
    Route::delete('/pengalaman/bulk-destroy', [PengalamanAdminController::class, 'destroyBulk'])->name('pengalaman.bulk-destroy');
    Route::resource('/pengalaman', PengalamanAdminController::class)->except(['show']);

    // Klien/Mitra
    Route::delete('/klien-mitra/bulk-destroy', [KlienMitraAdminController::class, 'destroyBulk'])->name('klien-mitra.bulk-destroy');
    Route::resource('/klien-mitra', KlienMitraAdminController::class)->except(['show']);

    // Testimoni
    Route::resource('/testimoni', TestimoniAdminController::class)->except(['show']);

    // Publikasi
    Route::resource('/publikasi', PublikasiAdminController::class)->except(['show']);

    // Kategori Publikasi
    Route::resource('/kategori-publikasi', KategoriPublikasiAdminController::class)->except(['show', 'create', 'edit']);

    // Tim Organisasi
    Route::resource('/tim-organisasi', TimOrganisasiAdminController::class)->except(['show']);

    // Galeri Slider (Kontak)
    Route::resource('/galeri-slider', GaleriSliderAdminController::class)->except(['show']);

    // Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting', [SettingController::class, 'update'])->name('setting.update');

    // Kontak
    Route::get('/kontak', [KontakAdminController::class, 'index'])->name('kontak.index');
    Route::get('/kontak/{kontak}', [KontakAdminController::class, 'show'])->name('kontak.show');
    Route::delete('/kontak/{kontak}', [KontakAdminController::class, 'destroy'])->name('kontak.destroy');

    // Logout
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');
});
