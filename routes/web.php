<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/explore', function () {
    return view('explore');
})->name('explore');

Route::get('/explore/karya-lainnya', function () {
    return view('explore-more');
})->name('explore.more');

Route::get('/work/{work:slug}', function (\App\Models\Work $work) {
    return "Detail karya: " . $work->title; 
})->name('work.show');

Route::get('/creators', function () {
    return view('creators');
})->name('creators');

Route::get('/creators/lainnya', function () {
    return view('creators-more');
})->name('creators.more');

Route::get('/creator/{creator:slug}', function (\App\Models\CreatorProfile $creator) {
    return view('creator-show', ['creator' => $creator]);
})->name('creator.show');

Route::get('/creator/{creator:slug}/karya', function (\App\Models\CreatorProfile $creator) {
    return "Semua karya dari " . $creator->name;
})->name('creator.works.more');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', function () {
    return view('about');
})->name('about');
// Route::view('/about', 'about')->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
