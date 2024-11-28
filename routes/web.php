<?php

use App\Http\Controllers\CommentController;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MovieController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('posts', PostController::class)->only('store', 'create', 'update', 'destroy')->middleware('can:create,App\Models\Post');;
    Route::resource('posts.comments', CommentController::class)->shallow()->only('store', 'destroy', 'update');
});

Route::get('/', [MovieController::class, 'dashboard'])->name('dashboard');

Route::resource('posts', PostController::class)->only('index');
Route::get('/posts/{post}/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');


Route::get('test', function () {
    return [
        UserResource::make(User::find(1)),
        PostResource::make(Post::find(1)),
        CommentResource::make(Comment::find(1))
    ];
});

