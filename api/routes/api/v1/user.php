<?php

use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->middleware('auth:sanctum')->group(function() {
    Route::post('', [UserController::class, 'create']);
    Route::get('', [UserController::class, 'get']);
});
