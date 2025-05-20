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

Route::middleware('guest')->group(function () {
    Route::get('dosen/login', [DosenAuthController::class, 'showLoginForm'])->name('dosen.login');
    Route::post('dosen/login', [DosenAuthController::class, 'login'])->name('dosen.login.auth');

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

    Route::prefix('mahasiswa')->controller(App\Http\Controllers\Admin\MahasiswaController::class)->group(function () {
        Route::get('/', 'index')->name('admin.mahasiswa');
        Route::get('/create', 'create')->name('admin.mahasiswa_create');
        Route::post('/create/store', 'store')->name('admin.mahasiswa_store');

        Route::get('/edit/{id}', 'edit')->name('admin.mahasiswa_edit');
        Route::put('/update/{id}', 'update')->name('admin.mahasiswa_update');

        Route::delete('/{id}', 'destroy')->name('admin.mahasiswa_destroy');
        Route::post('/verify', 'verify')->name('admin.mahasiswa_verify');
    });

    Route::prefix('kelas')->controller(App\Http\Controllers\Admin\KelasController::class)->group(function () {
        Route::get('/', 'index')->name('admin.kelas');
        Route::get('/create', 'create')->name('admin.kelas_create');
        Route::post('/create/store', 'store')->name('admin.kelas_store');

        Route::get('/edit/{id}', 'edit')->name('admin.kelas_edit');
        Route::put('/update/{id}', 'update')->name('admin.kelas_update');

        Route::delete('/{id}', 'destroy')->name('admin.kelas_destroy');
    });

    Route::prefix('matakuliah')->controller(App\Http\Controllers\Admin\MatakuliahController::class)->group(function () {
        Route::get('/', 'index')->name('admin.matakuliah');
        Route::get('/create', 'create')->name('admin.matakuliah_create');
        Route::post('/create/store', 'store')->name('admin.matakuliah_store');

        Route::get('/edit/{id}', 'edit')->name('admin.matakuliah_edit');
        Route::put('/update/{id}', 'update')->name('admin.matakuliah_update');

        Route::delete('/{id}', 'destroy')->name('admin.matakuliah_destroy');
    });

    Route::prefix('absensi')->controller(App\Http\Controllers\Admin\AbsensiController::class)->group(function () {
        Route::get('/', 'index')->name('admin.absensi');
        Route::get('/create', 'create')->name('admin.absensi_create');
        Route::post('/create/store', 'store')->name('admin.absensi_store');

        Route::get('/edit/{id}', 'edit')->name('admin.absensi_edit');
        Route::put('/update/{id}', 'update')->name('admin.absensi_update');

        Route::delete('/{id}', 'destroy')->name('admin.absensi_destroy');
    });

    Route::prefix('training')->controller(App\Http\Controllers\Admin\TrainingController::class)->group(function () {
        Route::get('/', 'index')->name('admin.training');
        Route::get('/create', 'create')->name('admin.training_create');
        Route::post('/create/store', 'store')->name('admin.training_store');
    });

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

    // Route::resource('mahasiswa', MahasiswaController::class);
    // Route::resource('kelas', KelasController::class);
    // Route::resource('matakuliah', MataKuliahController::class);
    // Route::resource('absensi', AbsensiController::class);

    // Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    //     ->name('logout');
});



Route::get('/images/{id}/{filename}', function ($id, $filename) {
    $path = base_path("scripts/Images/{$id}/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
