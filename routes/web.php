<?php

use App\Http\Controllers\Admin\AreaKerjaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JenisAlatController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\Admin\PengawasController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\UnitAlatController;
use App\Http\Controllers\Admin\UnitKerjaController;
use App\Http\Controllers\Admin\ZonaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\FormController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC — Form pengisian, TANPA LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', [FormController::class, 'index'])->name('form.index');
Route::post('/submit', [FormController::class, 'store'])->name('form.store');
Route::get('/terima-kasih', [FormController::class, 'thanks'])->name('form.thanks');

// endpoint AJAX cascading dropdown (publik, read-only)
Route::get('/ajax/area-kerja/{zona}', [FormController::class, 'getAreaKerja'])->name('ajax.areaKerja');
Route::get('/ajax/unit-alat/{areaKerja}/{jenis}', [FormController::class, 'getUnitAlatByJenis'])->name('ajax.unitAlat');
Route::get('/ajax/operators/{unitAlat}', [FormController::class, 'getOperators'])->name('ajax.operators');

/*
|--------------------------------------------------------------------------
| AUTH ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
});

Route::post('/admin/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN — Wajib login
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(ZonaController::class)->prefix('zonas')->name('zonas.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{zona}', 'update')->name('update');
        Route::delete('/{zona}', 'destroy')->name('destroy');
    });

    Route::controller(AreaKerjaController::class)->prefix('area-kerjas')->name('areaKerjas.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{areaKerja}', 'update')->name('update');
        Route::delete('/{areaKerja}', 'destroy')->name('destroy');
    });

    Route::controller(UnitKerjaController::class)->prefix('unit-kerjas')->name('unitKerjas.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{unitKerja}', 'update')->name('update');
        Route::delete('/{unitKerja}', 'destroy')->name('destroy');
    });

    Route::controller(JenisAlatController::class)->prefix('jenis-alats')->name('jenisAlats.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{jenisAlat}', 'update')->name('update');
        Route::delete('/{jenisAlat}', 'destroy')->name('destroy');
    });

    Route::controller(PengawasController::class)->prefix('pengawas')->name('pengawas.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{pengawas}', 'update')->name('update');
        Route::delete('/{pengawas}', 'destroy')->name('destroy');
    });

    Route::controller(OperatorController::class)->prefix('operators')->name('operators.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{operator}', 'update')->name('update');
        Route::delete('/{operator}', 'destroy')->name('destroy');
    });

    Route::controller(UnitAlatController::class)->prefix('unit-alats')->name('unitAlats.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{unitAlat}', 'update')->name('update');
        Route::delete('/{unitAlat}', 'destroy')->name('destroy');
    });

    Route::controller(SubmissionController::class)->prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export', 'export')->name('export');
        Route::delete('/{submission}', 'destroy')->name('destroy');
    });
});
