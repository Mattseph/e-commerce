<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('guest', 'redirect_admin')->prefix('admin')->group(function () {
    Route::get('create', [AdminAuthController::class, 'showloginForm'])->name('admin.create');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
});


Route::middleware('auth', 'is_admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::controller(ProductController::class)->prefix('product')->group( function () {

        Route::get('/', 'index')->name('admin.product.index');
        Route::get('/{id}', 'view')->name('admin.product.view');
        Route::get('/create', 'create')->name('admin.product.create');
        Route::post('/', 'store')->name('admin.product.store');
        Route::get('/edit/{id}', 'edit')->name('admin.product.edit');
        Route::put('/{id}', 'update')->name('admin.product.update');
        Route::delete('/', 'destroy')->name('admin.product.destroy');
    }
);

});
require __DIR__.'/auth.php';
