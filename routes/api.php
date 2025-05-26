<?php

use App\Http\Controllers\Api\GuruAuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\ModelDownloadController;
use App\Http\Controllers\Api\SiswaController;
use App\Models\Kelas;
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
    Route::get('/kelas', [GuruController::class, 'kelas'])->name('guru.kelas');
});

Route::get('/siswa/{id}', [SiswaController::class, 'show']);
Route::post('/siswa/create', [SiswaController::class, 'store']);
Route::get('/siswa/profile/{id}', [SiswaController::class, 'profile']);


Route::post('/guru/login', [GuruAuthController::class, 'login']);

Route::get('/models/list', [ModelDownloadController::class, 'getModelList']);
Route::get('/models/download/{filename}', [ModelDownloadController::class, 'downloadModel']);
Route::get('/models/download-all', [ModelDownloadController::class, 'downloadAllModels']);

Route::get('/kelas-by-email', function (\Illuminate\Http\Request $request) {
    $email = $request->query('email');

    if (!$email) {
        return response()->json([], 400);
    }

    $guru = \App\Models\Guru::where('email', $email)->first();

    if (!$guru) {
        return response()->json([]);
    }

    $kelas = Kelas::where('guru_id', $guru->id)->get(['id', 'nama']);

    return response()->json($kelas);
});
