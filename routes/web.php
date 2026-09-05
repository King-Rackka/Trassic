<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileShowController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Work\Create as WorkCreate;
use App\Livewire\Work\WorkEdit;


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


Route::get('/search', function () {
    return view('search');
})->name('search');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/work/{work:slug}', [WorkController::class, 'show'])->name('work.show');


Route::middleware('auth')->group(function () {
    Route::get('/works/create', WorkCreate::class)->name('works.create');
    Route::get('/works/{work}/edit', WorkEdit::class)->name('works.edit');
});

Route::get('/works/{id}', [WorkController::class, 'show'])->name('works.show');


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

Route::get('/waste-explorer', function () {
    return "Halaman Waste Explorer (belum dibangun)";
})->name('waste-explorer');

Route::get('/waste-explorer/{material}', function ($material) {
    return "Detail material: " . $material . " (belum dibangun)";
})->name('waste-explorer.show');


Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/works', function () {
        return "My Works (belum dibangun)";
    })->name('dashboard.works');

    Route::get('/works/{work}/edit', function (\App\Models\Work $work) {
        return "Edit karya: " . $work->title . " (belum dibangun)";
    })->name('dashboard.works.edit');

    Route::get('/saved', function () {
        return "Saved Works (belum dibangun)";
    })->name('dashboard.saved');
});

Route::middleware('auth')->group(function () {
    Route::view('/profile', 'profile.index')->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
