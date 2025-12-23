<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/about', 'pages.about')->name('pages.about');
Route::view('/contact', 'pages.contact')->name('pages.contact');

Route::resource('posts', PostController::class)
    ->scoped([
        'post' => 'slug',
    ])
    ->only([
    'index', 'show', 'create', 'store',
]);

Route::resource('posts.comments', CommentController::class)->only([
    'store',
]);

require __DIR__.'/auth.php';

Route::fallback(function () {
    abort(404, 'Oops! Page not found...');
});
