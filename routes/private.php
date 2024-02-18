<?php

use App\Http\Controllers\Authentication\UserController;
use App\Http\Controllers\RssFeed\RssFeedController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| PRIVATE API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api/private" middleware group. Make something great!
|
*/

Route::middleware(['auth:api'])->group(function () {
    Route::get('test', [UserController::class, 'test'])->name('user.test');
    
    Route::group(['prefix' => 'rss-feed'], function() {
        Route::post('start', [RssFeedController::class, 'start'])->name('fetch.start');
        Route::post('re-fetch', [RssFeedController::class, 'refetch'])->name('fetch.refetch');
        Route::post('stop', [RssFeedController::class, 'stop'])->name('fetch.stop');
        Route::post('clear', [RssFeedController::class, 'clear'])->name('fetch.clear');
    });
    
    
});

