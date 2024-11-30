<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\BarcodeController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('stores.index');
        } else {
            return redirect()->route('barcodes.index');
        }
    }
    return redirect()->route('login'); // Redirect to login if not authenticated
});

Route::get('/unauthorized-access', function () {
    return view('unauthorized');
})->middleware(['auth', 'verified'])->name('unauthorized');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::resource('stores', StoreController::class);
        Route::resource('users', UserController::class)->only(['index', 'create' , 'store' ,'edit', 'update', 'destroy']);
    });
    Route::resource('sizes', SizeController::class);
    Route::get('/barcodes', [BarcodeController::class, 'index'])->name('barcodes.index');
    Route::get('/barcodes/create', [BarcodeController::class, 'create'])->name('barcodes.create');
    Route::post('/barcodes', [BarcodeController::class, 'store'])->name('barcodes.store');
    Route::delete('/barcodes/{barcode}', [BarcodeController::class, 'destroy'])->name('barcodes.destroy');
    Route::put('/barcodes/updatePrice', [BarcodeController::class, 'updatePrice']);
    Route::get('/barcodes/generate/{sku}', [BarcodeController::class, 'generateBarcode']);


});
