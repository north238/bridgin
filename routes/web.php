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
use App\Http\Controllers\CsvFileUploadController;
use App\Http\Controllers\NotificationMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 資産一覧表示（ダッシュボード）
    Route::get('/dashboard', [YearlyAssetsController::class, 'yearlyAssetsIndex'])->name('assets.dashboard');

    // 各詳細画面表示
    Route::resource('/dashboard/assets', AssetsController::class);
    Route::get('/dashboard/debut', [DebutAssetController::class, 'debutAssetsIndex'])->name('assets.debut.index');
    Route::get('/dashboard/current-month', [CurrentMonthAssetController::class, 'currentMonthAssetsIndex'])->name('assets.currentMonth.index');

    // お知らせ機能
    Route::get('/dashboard/notification-message', [NotificationMessageController::class, 'index'])->name('notification.index');
    Route::get('/dashboard/notification-message/unread', [NotificationMessageController::class, 'unreadNotification'])->name('notification.unread');
    Route::get('/dashboard/notification-message/{notificationId}', [NotificationMessageController::class, 'detail'])->name('notification.detail');

    // 検索機能
    Route::post('/asset-search', [AssetSearchController::class, 'receiveSearchRequest'])->name('search.index');
    Route::get('/asset-search', [AssetSearchController::class, 'displaySearchResults'])->name('search.show');

    // 表示切替、CSVダウンロード機能
    Route::post('/asset-switch', [AssetSwitchStatusController::class, 'userDisplayMethodChange'])->name('assets.userDisplayMethodChange');
    Route::post('/csv-download', [CsvFileDownloadController::class, 'getFormRequestData'])->name('post.assets.csvDownload');
    Route::get('/download-template-csv', [CsvFileDownloadController::class, 'downloadTemplateCSV'])->name('get.template.csv');

    // CSVアップロード
    Route::post('/upload-csv', [CsvFileUploadController::class, 'upload'])->name('post.upload.csv');

    // 削除した資産の復元
    Route::get('/restore/show', [AssetRestoreController::class, 'showDeletedAssets'])->name('assets.showDeletedAssets');
    Route::get('/restore/{id}', [AssetRestoreController::class, 'restoreAsset'])->name('assets.restoreAsset');

    // 資産推移グラフ
    Route::get('/asset-trend', [AssetTrendController::class, 'showAssetTrend'])->name('asset-trend.index');
    Route::post('/asset-trend', [AssetTrendController::class, 'searchAssetData'])->name('asset-trend.search');
});

require __DIR__ . '/auth.php';
