<?php

use App\Http\Controllers\Authentication\UserController;
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
});

