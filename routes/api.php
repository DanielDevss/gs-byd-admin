<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/models', [VehicleController::class, 'index']);
Route::get('/models/{slug}', [VehicleController::class, 'show']);
Route::get('/slides', [SlideController::class, 'index']);

Route::post('/sent/{type}', [ContactController::class, 'sendContact']);