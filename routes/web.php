<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PengirimanController;
use App\Http\Controllers\Admin\PermintaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::controller(UserAuthController::class)->group(function () {
    Route::middleware('guest:user')->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('auth.login');
    });
    Route::middleware('user')->group(function () {
        Route::get('/logout', 'logout')->name('auth.logout');
    });
});

Route::middleware('guest:user')->group(function () {
    Route::controller(UserAuthController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('auth.login');
    });
});

Route::middleware('user')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });
    Route::controller(GudangController::class)->group(function () {
        Route::get('/gudang', 'index')->name('gudang');
        Route::get('/gudang/create', 'create')->name('gudang.create');
        Route::post('/gudang/store', 'store')->name('gudang.store');
        Route::post('/gudang/get', 'getGudang')->name('gudang.get');
        Route::get('/gudang/edit/{slug}/{role}', 'edit');
        Route::post('/gudang/update/{slug}/{role}', 'update')->name('gudang.update');
        Route::get('/gudang/destroy/{slug_gudang}/{slug_user}/{role}', 'destroy');
    });

    Route::controller(BarangController::class)->group(function () {
        Route::get('/barang', 'index')->name('barang');
        Route::post('/barang/get', 'getBarang')->name('barang.get');
        Route::get('/barang/create', 'create')->name('barang.create');
        Route::post('/barang/store', 'store')->name('barang.store');
        Route::get('/barang/edit/{slug}', 'edit');
        Route::post('/barang/update/{slug}', 'update')->name('barang.update');
        Route::get('/barang/destroy/{slug}', 'destroy');
    });

    Route::controller(UserAuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('auth.logout');
    });

    Route::controller(PermintaanController::class)->group(function () {
        Route::get('/permintaan', 'index')->name('permintaan');
        Route::get('/permintaan/create', 'create')->name('permintaan.create');
        Route::post('/permintaan/store', 'store')->name('permintaan.store');
        Route::get('/permintaan/show/{slug}', 'show')->name('permintaan.show');
    });

    Route::controller(PengirimanController::class)->group(function () {
        Route::get('/pengiriman', 'index')->name('pengiriman');
        Route::get('/pengiriman/create/{pengiriman_id}/{barang_gudang_produksi_id}', 'create')->name('pengiriman.create');
        Route::post('/pengiriman/temporary', 'temporary')->name('pengiriman.temporary');
        Route::get('/pengiriman/store/{permintaan_id}', 'store')->name('pengiriman.store');
        Route::get('/pengiriman/show/{pengiriman_id}', 'show')->name('pengiriman.show');
        Route::get('/pengiriman/update/{pengiriman_id}', 'update')->name('pengiriman.update');
    });
});
