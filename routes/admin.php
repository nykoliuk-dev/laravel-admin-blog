<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Main Page
        Route::get('/', DashboardController::class)->name('index');

        // Posts
        Route::resource('posts', PostController::class)
            ->scoped([
                'post' => 'slug',
            ]);

        // Tags
        Route::resource('tags', TagController::class)
            ->scoped([
                'tag' => 'slug',
            ]);

        // Categories
        Route::resource('categories', CategoryController::class)
            ->scoped([
                'category' => 'slug',
            ]);
    });
