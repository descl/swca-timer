<?php

use App\Http\Controllers\TimerController;
use Illuminate\Support\Facades\Route;

Route::prefix('/timer')->name('timer.')->group(function () {
    Route::post('/{timer}/start', [TimerController::class, 'start'])->name('start');
    Route::post('/{timer}/stop', [TimerController::class, 'stop'])->name('stop');
    Route::get('/{timer}/status', [TimerController::class, 'status'])->name('status');
})->middleware('auth:sanctum');
