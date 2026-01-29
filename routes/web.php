<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StoreCommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/about', 'pages.about')->name('pages.about');
Route::view('/contact', 'pages.contact')->name('pages.contact');

Route::resource('posts', PostController::class)
    ->scoped([
        'post' => 'slug',
    ]);

Route::post('/posts/{post}/comments', StoreCommentController::class)
    ->middleware('EnsureJsonRequest')
    ->name('posts.comments.store');

Route::fallback(function () {
    abort(404, 'Oops! Page not found...');
});
