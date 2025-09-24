<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/logout',[AdminController::class, 'adminLogout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    
    Route::get('/admin/profile',[AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/profile/store',[AdminController::class, 'profileStore'])->name('profile.store');
    Route::post('/admin/password/update',[AdminController::class, 'adminPasswordUpdate'])->name('admin.password.update');

});