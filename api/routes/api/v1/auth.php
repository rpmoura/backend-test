<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Auth\AuthController;

Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::post('/sign-in', [AuthController::class, 'signIn']);
});
