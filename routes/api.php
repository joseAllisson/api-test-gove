<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PermissionController;

Route::apiResource('users', UserController::class);
Route::apiResource('permissions', PermissionController::class);