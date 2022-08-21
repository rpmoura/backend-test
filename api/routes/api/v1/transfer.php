<?php

use App\Http\Controllers\V1\TransferController;
use Illuminate\Support\Facades\Route;

Route::prefix('transfers')->middleware(['auth:sanctum', 'can.abilities:can-transfer'])->group(function () {
    Route::post('', [TransferController::class, 'transfer']);
});
