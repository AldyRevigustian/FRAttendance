<?php

use App\Http\Controllers\Api\GuruAuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->prefix('guru')->group(function () {

        // Route::post('/logout', [GuruAuthController::class, 'logout'])->name('logout');
        // Route::get('/dashboard', [GuruAuthController::class, 'dashboard'])->name('dashboard');
    });
Route::post('/guru/login', [GuruAuthController::class, 'login']);
