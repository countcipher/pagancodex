<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'profile' => auth()->user()->profile,
        'eventsCount' => auth()->user()->events()->count(),
        'groupsCount' => auth()->user()->groups()->count(),
        'shopsCount' => auth()->user()->shops()->count(),
    ]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/public-profile', [PublicProfileController::class, 'edit'])->name('public-profile.edit');
    Route::patch('/public-profile', [PublicProfileController::class, 'update'])->name('public-profile.update');

    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [\App\Http\Controllers\EventController::class, 'create'])->name('events.create');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [\App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/groups', [\App\Http\Controllers\GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [\App\Http\Controllers\GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [\App\Http\Controllers\GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}/edit', [\App\Http\Controllers\GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'destroy'])->name('groups.destroy');

    Route::get('/shops', [\App\Http\Controllers\ShopController::class, 'index'])->name('shops.index');
    Route::get('/shops/create', [\App\Http\Controllers\ShopController::class, 'create'])->name('shops.create');
    Route::post('/shops', [\App\Http\Controllers\ShopController::class, 'store'])->name('shops.store');
    Route::get('/shops/{shop}/edit', [\App\Http\Controllers\ShopController::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{shop}', [\App\Http\Controllers\ShopController::class, 'update'])->name('shops.update');
    Route::delete('/shops/{shop}', [\App\Http\Controllers\ShopController::class, 'destroy'])->name('shops.destroy');
});

require __DIR__ . '/auth.php';