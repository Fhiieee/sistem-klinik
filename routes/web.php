<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| LUPA PASSWORD VIA EMAIL
|--------------------------------------------------------------------------
*/

Route::get('/lupa-password', [AuthController::class, 'lupaPassword'])->name('password.request');
Route::post('/lupa-password', [AuthController::class, 'kirimOtp'])->name('password.otp.send');
Route::get('/verifikasi-otp', [AuthController::class, 'formOtp'])->name('password.otp.form');
Route::post('/verifikasi-otp', [AuthController::class, 'verifikasiOtp'])->name('password.otp.verify');
Route::get('/reset-password', [AuthController::class, 'formResetOtp'])->name('password.otp.reset.form');
Route::post('/reset-password', [AuthController::class, 'prosesResetOtp'])->name('password.otp.reset');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN - PROFILE
|--------------------------------------------------------------------------
*/

Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
Route::put('/admin/password', [AdminController::class, 'updatePassword'])->name('admin.password.update');

/*
|--------------------------------------------------------------------------
| ADMIN - DATA PASIEN
|--------------------------------------------------------------------------
*/

Route::get('/admin/pasien', [AdminController::class, 'pasien'])->name('admin.pasien.index');
Route::get('/admin/pasien/ajax/search', [AdminController::class, 'searchPasienAjax'])
    ->name('admin.pasien.ajax.search');
Route::get('/admin/pasien/create', [AdminController::class, 'createPasien'])->name('admin.pasien.create');
Route::post('/admin/pasien', [AdminController::class, 'storePasien'])->name('admin.pasien.store');
Route::get('/admin/pasien/{id}/detail', [AdminController::class, 'detailPasien'])->name('admin.pasien.detail');
Route::get('/admin/pasien/{id}/edit', [AdminController::class, 'editPasien'])->name('admin.pasien.edit');
Route::put('/admin/pasien/{id}', [AdminController::class, 'updatePasien'])->name('admin.pasien.update');

/*
|--------------------------------------------------------------------------
| ADMIN - DATA DOKTER
|--------------------------------------------------------------------------
*/

Route::get('/admin/dokter', [AdminController::class, 'dokter'])->name('admin.dokter.index');

/*
| AJAX SEARCH DOKTER
| Catatan: route AJAX harus ditaruh sebelum route yang ada {id}
*/
Route::get('/admin/dokter/ajax/search', [AdminController::class, 'searchDokterAjax'])->name('admin.dokter.ajax.search');

Route::get('/admin/dokter/create', [AdminController::class, 'createDokter'])->name('admin.dokter.create');
Route::post('/admin/dokter', [AdminController::class, 'storeDokter'])->name('admin.dokter.store');
Route::get('/admin/dokter/{id}/detail', [AdminController::class, 'detailDokter'])->name('admin.dokter.detail');
Route::get('/admin/dokter/{id}/edit', [AdminController::class, 'editDokter'])->name('admin.dokter.edit');
Route::put('/admin/dokter/{id}', [AdminController::class, 'updateDokter'])->name('admin.dokter.update');

/*
|--------------------------------------------------------------------------
| ADMIN - DATA POLI
|--------------------------------------------------------------------------
*/

Route::get('/admin/poli', [AdminController::class, 'poli'])->name('admin.poli.index');
Route::get('/admin/poli/ajax/search', [AdminController::class, 'searchPoliAjax'])
    ->name('admin.poli.ajax.search');
Route::get('/admin/poli/create', [AdminController::class, 'createPoli'])->name('admin.poli.create');
Route::post('/admin/poli', [AdminController::class, 'storePoli'])->name('admin.poli.store');
Route::get('/admin/poli/{id}/edit', [AdminController::class, 'editPoli'])->name('admin.poli.edit');
Route::put('/admin/poli/{id}', [AdminController::class, 'updatePoli'])->name('admin.poli.update');
Route::delete('/admin/poli/{id}', [AdminController::class, 'destroyPoli'])->name('admin.poli.destroy');

/*
|--------------------------------------------------------------------------
| ADMIN - JADWAL DOKTER
|--------------------------------------------------------------------------
*/

Route::get('/admin/jadwal', [AdminController::class, 'jadwal'])->name('admin.jadwal.index');
Route::get('/admin/jadwal/ajax/search', [AdminController::class, 'searchJadwalAjax'])
    ->name('admin.jadwal.ajax.search');
Route::get('/admin/jadwal/create', [AdminController::class, 'createJadwal'])->name('admin.jadwal.create');
Route::post('/admin/jadwal', [AdminController::class, 'storeJadwal'])->name('admin.jadwal.store');
Route::get('/admin/jadwal/{id}/edit', [AdminController::class, 'editJadwal'])->name('admin.jadwal.edit');
Route::put('/admin/jadwal/{id}', [AdminController::class, 'updateJadwal'])->name('admin.jadwal.update');
Route::delete('/admin/jadwal/{id}', [AdminController::class, 'destroyJadwal'])->name('admin.jadwal.destroy');

/*
|--------------------------------------------------------------------------
| ADMIN - DATA PENDAFTARAN
|--------------------------------------------------------------------------
*/

Route::get('/admin/pendaftaran', [AdminController::class, 'pendaftaran'])->name('admin.pendaftaran.index');
Route::get('/admin/pendaftaran/ajax/search', [AdminController::class, 'searchPendaftaranAjax'])
    ->name('admin.pendaftaran.ajax.search');
Route::get('/admin/pendaftaran/create', [AdminController::class, 'createPendaftaran'])->name('admin.pendaftaran.create');
Route::post('/admin/pendaftaran', [AdminController::class, 'storePendaftaran'])->name('admin.pendaftaran.store');
Route::get('/admin/pendaftaran/{id}/edit', [AdminController::class, 'editPendaftaran'])->name('admin.pendaftaran.edit');
Route::put('/admin/pendaftaran/{id}', [AdminController::class, 'updatePendaftaran'])->name('admin.pendaftaran.update');
Route::delete('/admin/pendaftaran/{id}', [AdminController::class, 'destroyPendaftaran'])->name('admin.pendaftaran.destroy');

/*
|--------------------------------------------------------------------------
| ADMIN - LAPORAN PEMERIKSAAN
|--------------------------------------------------------------------------
*/

Route::get('/admin/laporan', [AdminController::class, 'laporanPemeriksaan'])->name('admin.laporan.index');
Route::get('/admin/laporan/ajax/search', [AdminController::class, 'searchLaporanAjax'])
    ->name('admin.laporan.ajax.search');
Route::get('/admin/laporan/{id}/detail', [AdminController::class, 'detailLaporanPemeriksaan'])->name('admin.laporan.detail');

/*
|--------------------------------------------------------------------------
| DOKTER
|--------------------------------------------------------------------------
*/

Route::get('/dokter/dashboard', [DokterController::class, 'dashboard'])->name('dokter.dashboard');

Route::get('/dokter/profile', [DokterController::class, 'profile'])->name('dokter.profile');
Route::put('/dokter/profile', [DokterController::class, 'updateProfile'])->name('dokter.profile.update');

Route::get('/dokter/jadwal', [DokterController::class, 'jadwal'])->name('dokter.jadwal.index');

Route::get('/dokter/pemeriksaan', [DokterController::class, 'pemeriksaan'])->name('dokter.pemeriksaan.index');
Route::get('/dokter/pemeriksaan/{pendaftaranId}/create', [DokterController::class, 'createPemeriksaan'])->name('dokter.pemeriksaan.create');
Route::post('/dokter/pemeriksaan/{pendaftaranId}', [DokterController::class, 'storePemeriksaan'])->name('dokter.pemeriksaan.store');
Route::get('/dokter/pemeriksaan/detail/{pemeriksaanId}', [DokterController::class, 'detailPemeriksaan'])->name('dokter.pemeriksaan.detail');

Route::get('/dokter/laporan', [DokterController::class, 'laporan'])->name('dokter.laporan.index');

/*
|--------------------------------------------------------------------------
| PASIEN
|--------------------------------------------------------------------------
*/

Route::get('/pasien/dashboard', [PasienController::class, 'dashboard'])->name('pasien.dashboard');

Route::get('/pasien/jadwal', [PasienController::class, 'jadwal'])->name('pasien.jadwal.index');

Route::get('/pasien/pendaftaran', [PasienController::class, 'pendaftaran'])->name('pasien.pendaftaran.index');
Route::get('/pasien/pendaftaran/tambah', [PasienController::class, 'createPendaftaran'])->name('pasien.pendaftaran.create');
Route::post('/pasien/pendaftaran', [PasienController::class, 'storePendaftaran'])->name('pasien.pendaftaran.store');

Route::get('/pasien/riwayat', [PasienController::class, 'riwayat'])->name('pasien.riwayat.index');

Route::get('/pasien/profile', [PasienController::class, 'profile'])->name('pasien.profile');
Route::put('/pasien/profile', [PasienController::class, 'updateProfile'])->name('pasien.profile.update');
