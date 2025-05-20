<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\DosenAuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('training', TrainingController::class);
    Route::post('/mahasiswa/verify', [MahasiswaController::class, 'verify'])->name('mahasiswa.verify');
    Route::resource('kelas', KelasController::class);
    Route::resource('matakuliah', MataKuliahController::class);
    Route::resource('absensi', AbsensiController::class);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::prefix('dosen')->middleware(['dosen'])->group(function () {
    Route::get('/dashboard', function () {
        return "HALLo";
        // return view('dashboard');
    })->name('dosen.dashboard');

    Route::get('/', function () {
        return redirect()->route('dosen.dashboard');
    });

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::resource('mahasiswa', MahasiswaController::class);
    // Route::resource('kelas', KelasController::class);
    // Route::resource('matakuliah', MataKuliahController::class);
    // Route::resource('absensi', AbsensiController::class);

    // Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    //     ->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('dosen/login', [DosenAuthController::class, 'showLoginForm'])->name('dosen.login');
    Route::post('dosen/login', [DosenAuthController::class, 'login'])->name('dosen.login.auth');

    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.auth');
});



Route::get('/images/{id}/{filename}', function ($id, $filename) {
    $path = base_path("scripts/Images/{$id}/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
// require __DIR__ . '/auth.php';
