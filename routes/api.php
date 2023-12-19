<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AddressBookController;

Route::post('/login', [AuthController::class, 'login']);

route::group([
    'middleware' => ['auth:api'],
], function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('address-books', AddressBookController::class);
    Route::apiResource('users', UserController::class);
});
