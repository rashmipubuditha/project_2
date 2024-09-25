<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\Postcontroller;
use App\Http\Controllers\Commentcontroller;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [Authcontroller::class, 'register'])->name('posts.register');

Route::post('/login', [Authcontroller::class, 'login'])->name('posts.login');

Route::get('/', [Postcontroller::class, 'index'])->name('posts.index');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::post('posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store'); // Create a comment
Route::put('posts/{postId}/comments/{commentId}', [CommentController::class, 'update'])->name('comments.update'); // update a comment
Route::delete('posts/{postId}/comments/{commentId}', [CommentController::class, 'delete'])->name('comments.delete'); // Delete a comment

Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');