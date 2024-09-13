<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

Route::get('/dashboard', [WebController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/posts/create', [WebController::class, 'create']);
});

Route::get('/', [WebController::class, 'listBlog']);
Route::get('/post/{id}', [WebController::class, 'show']);
Route::get('/posts/{id}', [WebController::class, 'showBlog']);

Route::middleware('auth')->group(function () {
    Route::post('/posts', [WebController::class, 'store']);
    Route::put('/posts/{id}', [WebController::class, 'update']);
    Route::delete('/posts/{id}', [WebController::class, 'destroy']);
    Route::get('/posts/{id}/edit', [WebController::class, 'edit']);
});

Route::post('/comments/{id}', [CommentController::class, 'store'])->middleware('auth');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('auth');

require __DIR__ . '/auth.php';
