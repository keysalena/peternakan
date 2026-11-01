<?php
use App\Http\Controllers\Admin\{AktivitasController, DashboardController, MitraController, PembayaranController, PengajuanController, PeriodeController, StokController, TransaksiController};
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

// --- autentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'show'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});
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

    Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
});
