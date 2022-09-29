<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GudangController;

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
    Route::controller(UserAuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('auth.logout');
    });
});
