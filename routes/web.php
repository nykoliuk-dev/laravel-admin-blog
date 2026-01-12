<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreCommentController;
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

Route::post('/posts/{post}/comments', StoreCommentController::class)
    ->name('posts.comments.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::fallback(function () {
    abort(404, 'Oops! Page not found...');
});
