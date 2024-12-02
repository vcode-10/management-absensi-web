<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/absen', [App\Http\Controllers\ApiController::class, 'absen']);
Route::post('/testabsen', [App\Http\Controllers\ApiController::class, 'testabsen']);
Route::post('/login', [App\Http\Controllers\ApiController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\ApiController::class, 'logout']);
Route::get('/test', function () {
    return "hallo";
});
