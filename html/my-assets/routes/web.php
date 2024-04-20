<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Asset\AssetRestoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Asset\AssetsController;
use App\Http\Controllers\Asset\YearlyAssetsController;
use App\Http\Controllers\AssetSwitchStatusController;
use App\Http\Controllers\CsvFilesController;
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
    Route::post('/asset-switch', [AssetSwitchStatusController::class, 'userDisplayMethodChange'])->name('assets.userDisplayMethodChange');
    Route::post('/csv-export', [CsvFilesController::class, 'csvExport'])->name('assets.csvExport');
    Route::post('/pagination-index', [AjaxController::class, 'ajaxPaginationIndex'])->name('ajax.pagination.index');
    Route::get('/pagination-show', [AjaxController::class, 'ajaxPaginationShow'])->name('ajax.pagination.show');
    Route::post('/sort/get', [AjaxController::class, 'getSortFetchData'])->name('sort.get');
    Route::get('/sort/post', [AjaxController::class, 'PostSortData'])->name('sort.post');
});

Route::middleware('auth')->group(function() {
    Route::get('/restore/show', [AssetRestoreController::class, 'showDeletedAssets'])->name('assets.showDeletedAssets');
    Route::get('/restore/{id}', [AssetRestoreController::class, 'restoreAsset'])->name('assets.restoreAsset');
    Route::post('/restore/{id}', [AssetRestoreController::class, 'restoreAsset'])->name('assets.restoreAsset');
});

require __DIR__.'/auth.php';
