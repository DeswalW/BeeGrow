<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UmkmController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KeranjangController;

Route::get('/', [HomeController::class, 'welcome'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/project/{project_id}', [ProjectController::class, 'index'])->name('project');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    });

    Route::middleware('role:investor')->prefix('investor')->name('investor.')->group(function () {
        Route::get('/portofolio', [InvestorController::class, 'portofolio'])->name('portofolio');
        Route::get('/keranjang', [InvestorController::class, 'keranjang'])->name('keranjang');
        Route::post('/keranjang/add', [InvestorController::class, 'addToKeranjang'])->name('keranjang.add');
        Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
        Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');
        Route::get('/payment/{projectId}', [PaymentController::class, 'showPaymentPage'])->name('payment.show');
        Route::delete('/keranjang/{projectId}', [KeranjangController::class, 'destroy'])->name('investor.keranjang.destroy');
    });
    
    Route::middleware('role:umkm')->prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/dashboard', [UmkmController::class, 'index'])->name('dashboard');
        Route::get('/profile/create', [UmkmController::class, 'createProfile'])->name('profile.create');
        Route::post('/profile', [UmkmController::class, 'storeProfile'])->name('profile.store');
        Route::get('/projects/create', [UmkmController::class, 'create'])->name('projects.create');
        Route::post('/projects', [UmkmController::class, 'store'])->name('projects.store');
    });
});

Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

require __DIR__.'/auth.php';