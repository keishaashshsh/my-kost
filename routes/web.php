<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Middleware\RoleMiddleware as R;
use Illuminate\Support\Facades\Route;

// ===== Halaman publik =====
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/kamar', [PublicController::class, 'catalog'])->name('catalog');
Route::get('/kamar/{room}', [PublicController::class, 'show'])->name('rooms.show');

// ===== Harus login =====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/kamar/{room}/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/tagihan/{bill}/kuitansi', [BillController::class, 'receipt'])->name('bills.receipt');

    // ----- Penghuni -----
    Route::middleware(R::class . ':penghuni')->group(function () {
        Route::get('/tagihan-saya', [BillController::class, 'mine'])->name('bills.mine');
        Route::post('/tagihan/{bill}/bukti', [BillController::class, 'proof'])->name('bills.proof');
        Route::get('/keluhan-saya', [ComplaintController::class, 'mine'])->name('complaints.mine');
        Route::post('/keluhan', [ComplaintController::class, 'store'])->name('complaints.store');
        Route::post('/kontrak/{contract}/perpanjang', [ContractController::class, 'extend'])->name('contracts.extend');
        Route::post('/kontrak/{contract}/akhiri', [ContractController::class, 'end'])->name('contracts.end');
    });

    // ----- Pemilik & Admin -----
    Route::middleware(R::class . ':owner,admin')->prefix('kelola')->name('manage.')->group(function () {
        Route::resource('rooms', RoomController::class)->except('show');

        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

        Route::get('tenants', [TenantController::class, 'index'])->name('tenants.index');
        Route::post('tenants', [TenantController::class, 'store'])->name('tenants.store');

        Route::get('bills', [BillController::class, 'index'])->name('bills.index');
        Route::post('bills/generate', [BillController::class, 'generate'])->name('bills.generate');
        Route::post('bills/{bill}/meter', [BillController::class, 'meter'])->name('bills.meter');
        Route::post('bills/{bill}/verify', [BillController::class, 'verify'])->name('bills.verify');
        Route::post('bills/{bill}/reject', [BillController::class, 'reject'])->name('bills.reject');

        Route::get('complaints', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::patch('complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
    });

    // ----- Khusus Pemilik -----
    Route::middleware(R::class . ':owner')->prefix('kelola')->name('manage.')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });
});

require __DIR__ . '/auth.php';
