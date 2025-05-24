<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GuruAuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('guru/login', [GuruAuthController::class, 'showLoginForm'])->name('guru.login');
    Route::post('guru/login', [GuruAuthController::class, 'login'])->name('guru.login.auth');

    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.auth');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::prefix('siswa')->controller(App\Http\Controllers\Admin\SiswaController::class)->group(function () {
        Route::get('/', 'index')->name('admin.siswa');
        Route::get('/create', 'create')->name('admin.siswa_create');
        Route::post('/create/store', 'store')->name('admin.siswa_store');

        Route::get('/edit/{id}', 'edit')->name('admin.siswa_edit');
        Route::put('/update/{id}', 'update')->name('admin.siswa_update');

        Route::delete('/{id}', 'destroy')->name('admin.siswa_destroy');
        Route::post('/verify', 'verify')->name('admin.siswa_verify');
    });

    Route::prefix('guru')->controller(App\Http\Controllers\Admin\GuruController::class)->group(function () {
        Route::get('/', 'index')->name('admin.guru');
        Route::get('/create', 'create')->name('admin.guru_create');
        Route::post('/create/store', 'store')->name('admin.guru_store');

        Route::get('/edit/{id}', 'edit')->name('admin.guru_edit');
        Route::put('/update/{id}', 'update')->name('admin.guru_update');

        Route::delete('/{id}', 'destroy')->name('admin.guru_destroy');
    });

    Route::prefix('kelas')->controller(App\Http\Controllers\Admin\KelasController::class)->group(function () {
        Route::get('/', 'index')->name('admin.kelas');
        Route::get('/create', 'create')->name('admin.kelas_create');
        Route::post('/create/store', 'store')->name('admin.kelas_store');

        Route::get('/edit/{id}', 'edit')->name('admin.kelas_edit');
        Route::put('/update/{id}', 'update')->name('admin.kelas_update');

        Route::delete('/{id}', 'destroy')->name('admin.kelas_destroy');
    });

    Route::prefix('absensi')->controller(App\Http\Controllers\Admin\AbsensiController::class)->group(function () {
        Route::get('/', 'index')->name('admin.absensi');
        Route::get('/create', 'create')->name('admin.absensi_create');
        Route::post('/create/store', 'store')->name('admin.absensi_store');

        Route::get('/edit/{id}', 'edit')->name('admin.absensi_edit');
        Route::put('/update/{id}', 'update')->name('admin.absensi_update');

        Route::delete('/{id}', 'destroy')->name('admin.absensi_destroy');
    });


    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::prefix('guru')->middleware(['guru'])->group(function () {
    Route::get('/dashboard', function () {
        return "HALLo";
        // return view('dashboard');
    })->name('guru.dashboard');

    Route::get('/', function () {
        return redirect()->route('guru.dashboard');
    });
});



Route::get('/images/{id}/{filename}', function ($id, $filename) {
    $path = base_path("scripts/Images/{$id}/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
