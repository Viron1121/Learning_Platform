<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ChoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('projects', ProjectController::class);

    Route::get('/projects/{project}/choices', [ChoiceController::class, 'index']);
    Route::post('/projects/{project}/choices', [ChoiceController::class, 'store']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
