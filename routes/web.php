<?php
use App\Http\Controllers\Admin\{AktivitasController, DashboardController, MitraController, PembayaranController, PengajuanController, PeriodeController, StokController, TransaksiController};
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\Mitra\PortalController;
use App\Http\Middleware\{EnsureAdmin, EnsureMitra};
use Illuminate\Support\Facades\Route;

// --- publik ---
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('daftar', [LandingController::class, 'daftar'])->middleware('guest')->name('daftar');

// --- autentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'show'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});
Route::get('nota/{transaksi}', [NotaController::class, 'show'])->middleware('auth')->name('nota');
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', EnsureAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('mitra', [MitraController::class, 'index'])->name('mitra.index');
    Route::post('mitra', [MitraController::class, 'store'])->name('mitra.store');
    Route::patch('mitra/{mitra}/verifikasi', [MitraController::class, 'verifikasi'])->name('mitra.verifikasi');

    Route::get('periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::post('periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::patch('periode/{periode}', [PeriodeController::class, 'update'])->name('periode.update');

    Route::get('aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');
    Route::post('aktivitas', [AktivitasController::class, 'store'])->name('aktivitas.store');

    Route::get('stok', [StokController::class, 'index'])->name('stok.index');
    Route::patch('stok/{stok}', [StokController::class, 'update'])->name('stok.update');

    Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::post('pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::patch('pengajuan/{pengajuan}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan.tolak');
    Route::post('pengajuan/{pengajuan}/proses', [TransaksiController::class, 'store'])->name('pengajuan.proses');

    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/{transaksi}/scan', [TransaksiController::class, 'scan'])->middleware('signed')->name('transaksi.scan');
    Route::patch('transaksi/{transaksi}/konfirmasi', [TransaksiController::class, 'konfirmasi'])->name('transaksi.konfirmasi');

    Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
});

// --- portal mitra ---
Route::middleware(['auth', EnsureMitra::class])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('pengajuan', [PortalController::class, 'pengajuan'])->name('pengajuan.index');
    Route::post('pengajuan', [PortalController::class, 'storePengajuan'])->name('pengajuan.store');
    Route::get('transaksi', [PortalController::class, 'transaksi'])->name('transaksi.index');
    Route::get('pembayaran', [PortalController::class, 'pembayaran'])->name('pembayaran.index');
});
