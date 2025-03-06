<?php

use App\Http\Controllers\StocksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(StocksController::class)->group(function () {
    Route::get('/v1/stocks', 'index');
});
