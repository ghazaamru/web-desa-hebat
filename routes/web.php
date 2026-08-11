<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Support\Facades\Route;

Route::middleware(TrackVisitor::class)->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::livewire('peta-potensi', 'pages::peta-potensi')->name('peta-potensi');
    Route::livewire('katalog-usaha', 'pages::katalog-usaha')->name('katalog-usaha');
    Route::livewire('berita', 'pages::berita-index')->name('berita.index');
    Route::livewire('berita/{slug}', 'pages::berita-detail')->name('berita.show');
    Route::livewire('pengaduan', 'pages::pengaduan')->name('pengaduan.create');
    Route::livewire('profil', 'pages::profil-desa')->name('profil');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::livewire('dashboard/manage-content', 'pages::manage-content')
        ->middleware('can:manage-content')
        ->name('manage-content');
});

require __DIR__.'/settings.php';
