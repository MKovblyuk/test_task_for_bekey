<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::name('tasks.')->prefix('tasks')->group(function () {
        Route::patch('{task}/complete', [TaskController::class, 'complete'])->name('complete');
        Route::patch('{task}/uncomplete', [TaskController::class, 'uncomplete'])->name('uncomplete');
    });
    Route::apiResource('tasks', TaskController::class);

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
});

