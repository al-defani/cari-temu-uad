<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Models\Item;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    $totalHilang = Item::where('jenis', 'hilang')->where('status', 'aktif')->count();
    $totalTemu = Item::where('jenis', 'temu')->where('status', 'aktif')->count();
    $totalSelesai = Item::where('status', 'selesai')->count();

    return view('welcome', compact('totalHilang', 'totalTemu', 'totalSelesai'));
});

Route::get('/dashboard', [ItemController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/lapor', [ItemController::class, 'create'])->name('items.create');
    Route::post('/lapor', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('/laporanku', [ItemController::class, 'myReports'])->name('items.my-reports');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/items/{item}', [AdminController::class, 'destroy'])->name('items.destroy');
});


require __DIR__ . '/auth.php';
