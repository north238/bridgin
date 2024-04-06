<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Asset\AssetsController;
use App\Http\Controllers\Asset\YearlyAssetsController;
use App\Http\Controllers\AssetSwitchStatusController;
use App\Http\Controllers\CsvFilesController;
use App\Models\AssetSwitchStatus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function() {
    Route::get('/assets/yearly', [YearlyAssetsController::class, 'yearlyAssetsIndex'])->name('assets.yearly.index');
});

// 資産全般の処理、資産表示、CSVダウンロード機能
Route::middleware('auth')->group(function() {
    Route::resource('assets', AssetsController::class);
    Route::post('/assets/asset-switch', [AssetSwitchStatusController::class, 'userDisplayMethodChange'])->name('assets.userDisplayMethodChange');
    Route::post('/assets/csv-export', [CsvFilesController::class, 'csvExport'])->name('assets.csvExport');
    Route::get('/assets/ajax/index', [AjaxController::class, 'ajaxPaginationIndex'])->name('ajax.pagination.index');
    Route::post('/assets/ajax/index', [AjaxController::class, 'ajaxPaginationIndex'])->name('ajax.pagination.index');
    Route::post('/assets/sort', [AjaxController::class, 'sortIndex'])->name('ajax.sort.index');
    Route::get('/assets/sort', [AjaxController::class, 'sortUpdate'])->name('ajax.sort.update');
});

require __DIR__.'/auth.php';
