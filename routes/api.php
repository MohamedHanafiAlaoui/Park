<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ParkController;
use App\Http\Controllers\ReservationController;

Route::apiResource('users', UserController::class);
Route::apiResource('parks', ParkController::class);
Route::apiResource('reservations', ReservationController::class);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('welcome', function () {
    return 'welcome to api';
});

Route::post('register', [UserController::class ,'register']);
Route::post('login', [UserController::class ,'login']);
Route::post('logout', [UserController::class ,'logout'])->middleware('auth:sanctum');

