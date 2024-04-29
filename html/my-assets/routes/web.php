<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Asset\YearlyAssetsController;
use App\Http\Controllers\Asset\AssetsController;
use App\Http\Controllers\Asset\DebutAssetController;
use App\Http\Controllers\Asset\AssetRestoreController;
use App\Http\Controllers\Asset\AssetTrendController;
use App\Http\Controllers\AssetSwitchStatusController;
use App\Http\Controllers\CsvFilesController;
use Illuminate\Support\Facades\Route;

Route::get('/sample', function () {
    return view('sample2');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [YearlyAssetsController::class, 'yearlyAssetsIndex'])->name('assets.yearly.index');
    Route::resource('assets', AssetsController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/debut', [DebutAssetController::class, 'debutAssetsIndex'])->name('assets.debut.index');
});

// 資産全般の処理、資産表示、CSVダウンロード機能
Route::middleware('auth')->group(function() {
    Route::post('/asset-switch', [AssetSwitchStatusController::class, 'userDisplayMethodChange'])->name('assets.userDisplayMethodChange');
    Route::post('/csv-export', [CsvFilesController::class, 'csvExport'])->name('assets.csvExport');
    Route::post('/pagination/index', [AjaxController::class, 'ajaxPaginationIndex'])->name('ajax.pagination.index');
    Route::get('/pagination/show', [AjaxController::class, 'ajaxPaginationShow'])->name('ajax.pagination.show');
    Route::post('/sort/get', [AjaxController::class, 'getSortFetchData'])->name('sort.get');
    Route::get('/sort/post', [AjaxController::class, 'PostSortData'])->name('sort.post');
});

// 削除した資産の復元
Route::middleware('auth')->group(function() {
    Route::get('/restore/show', [AssetRestoreController::class, 'showDeletedAssets'])->name('assets.showDeletedAssets');
    Route::get('/restore/{id}', [AssetRestoreController::class, 'restoreAsset'])->name('assets.restoreAsset');
    Route::post('/restore/{id}', [AssetRestoreController::class, 'restoreAsset'])->name('assets.restoreAsset');
});

// 資産推移
Route::middleware('auth')->group(function() {
    Route::get('/asset-trend', [AssetTrendController::class, 'showAssetTrend'])->name('asset-trend.index');
    
});

require __DIR__.'/auth.php';
