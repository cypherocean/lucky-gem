<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::group(['middleware' => ['prevent-back-history']], function () {

    // Guest routes should not be wrapped in 'auth'
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::get('forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');
        Route::post('password-forget', [AuthController::class, 'passwordForget'])->name('password.forget');
        Route::get('reset-password/{string}', [AuthController::class, 'resetPassword'])->name('reset.password');
        Route::post('recover-password', [AuthController::class, 'recoverPassword'])->name('recover.password');
    });

    // Auth routes should be wrapped in 'auth'
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
