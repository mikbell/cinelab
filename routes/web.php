<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OmdbController;
use App\Http\Controllers\PostController;


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {

// });

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/movies', [OmdbController::class, 'index'])->name('movies.index');
Route::get('/movies/{imdbId}', [OmdbController::class, 'show'])->name('movies.show');