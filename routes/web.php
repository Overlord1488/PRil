<?php

use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\DirectionController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/programs', [CatalogController::class, 'programs'])->name('catalog.programs');
Route::get('/catalog/nutrition', [CatalogController::class, 'nutrition'])->name('catalog.nutrition');
Route::get('/catalog/category/{slug}', [CatalogController::class, 'category'])->name('catalog.category');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
Route::get('/trainers/{slug}', [TrainerController::class, 'show'])->name('trainers.show');

Route::get('/directions', [DirectionController::class, 'index'])->name('directions.index');
Route::get('/directions/{slug}', [DirectionController::class, 'show'])->name('directions.show');

Route::view('/about', 'public.about')->name('about');
Route::view('/contacts', 'public.contacts')->name('contacts');

Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
