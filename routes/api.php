<?php

use App\Http\Controllers\CubeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CubeController::class)->group(function () {
    Route::get('/cube', 'index');
});

Route::middleware('sideRequestBody')->controller(\App\Http\Controllers\SideController::class)
    ->group(function () {
        Route::put('/side/{id}', 'update');
    });
