
<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Authcontroller;

Route::post('/register', [Authcontroller::class, 'register'])->name('posts.register');
