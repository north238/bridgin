<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Asset\YearlyAssetsController;
use App\Http\Controllers\Asset\AssetsController;
use App\Http\Controllers\Asset\DebutAssetController;
use App\Http\Controllers\Asset\AssetRestoreController;
use App\Http\Controllers\Asset\AssetSearchController;
use App\Http\Controllers\Asset\AssetTrendController;
use App\Http\Controllers\Asset\CurrentMonthAssetController;
use App\Http\Controllers\AssetSwitchStatusController;
use App\Http\Controllers\CsvFileDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 資産一覧表示（ダッシュボード）
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [YearlyAssetsController::class, 'yearlyAssetsIndex'])->name('assets.dashboard');
});

// 各詳細画面表示
Route::middleware('auth')->group(function () {
    Route::resource('/dashboard/assets', AssetsController::class);
    Route::get('/dashboard/debut', [DebutAssetController::class, 'debutAssetsIndex'])->name('assets.debut.index');
    Route::get('/dashboard/current-month', [CurrentMonthAssetController::class, 'currentMonthAssetsIndex'])->name('assets.currentMonth.index');
});

// 検索機能
Route::middleware('auth')->group(function () {
    Route::post('/asset-search', [AssetSearchController::class, 'receiveSearchRequest'])->name('search.index');
    Route::get('/asset-search', [AssetSearchController::class, 'displaySearchResults'])->name('search.show');
});

// 表示切替、CSVダウンロード機能
Route::middleware('auth')->group(function() {
    Route::post('/asset-switch', [AssetSwitchStatusController::class, 'userDisplayMethodChange'])->name('assets.userDisplayMethodChange');
    Route::post('/csv-download', [CsvFileDownloadController::class, 'getFormRequestData'])->name('post.assets.csvDownload');
});

// 削除した資産の復元
Route::middleware('auth')->group(function() {
    Route::get('/restore/show', [AssetRestoreController::class, 'showDeletedAssets'])->name('assets.showDeletedAssets');
    Route::get('/restore/{id}', [AssetRestoreController::class, 'restoreAsset'])->name('assets.restoreAsset');
});

// 資産推移グラフ
Route::middleware('auth')->group(function() {
    Route::get('/asset-trend', [AssetTrendController::class, 'showAssetTrend'])->name('asset-trend.index');
    Route::post('/asset-trend', [AssetTrendController::class, 'showAssetTrend'])->name('asset-trend.search');
});

require __DIR__.'/auth.php';
