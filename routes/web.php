<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Articles\Index as ArticlesIndex;
use App\Livewire\Articles\Show as ArticlesShow;
use App\Livewire\Users\Index as UsersIndex;

Route::view('/', 'welcome');

// Rotas protegidas
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    // 🔥 ROTAS DE ARTICLES (Livewire)
    Route::get('/articles', ArticlesIndex::class)
        ->name('articles.index');
    
    Route::get('/articles/{slug}', ArticlesShow::class)
        ->name('articles.show');

    // 🔥 ROTAS DE USERS (Livewire) - Apenas Admin
    Route::middleware('can:isAdmin')->group(function () {
        Route::get('/users', UsersIndex::class)
            ->name('users.index');
    });
});

// Rotas de autenticação Breeze
require __DIR__.'/auth.php';
