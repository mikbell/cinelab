<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('posts', PostController::class)->only('store', 'create', 'update', 'destroy')->middleware('can:create,App\Models\Post');
    Route::resource('posts.comments', CommentController::class)->shallow()->only('store', 'destroy', 'update');

    Route::post('/likes/{type}/{id}', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes/{type}/{id}', [LikeController::class, 'destroy'])->name('likes.destroy');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{movie}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{movie}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

Route::get('/', [MovieController::class, 'dashboard'])->name('dashboard');

Route::get('/posts/{topic?}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');


Route::get('test', function () {
    return [
        UserResource::make(User::find(1)),
        PostResource::make(Post::find(1)),
        CommentResource::make(Comment::find(1))
    ];
});

