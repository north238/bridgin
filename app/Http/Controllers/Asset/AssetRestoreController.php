<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\AssetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetRestoreController extends Controller
{
    private $assets;
    private $assetService;

    public function __construct(
        Asset $assets,
        AssetService $assetService
    ) {
        $this->assets = $assets;
        $this->assetService = $assetService;
    }

    /**
     * 削除された資産一覧の表示
     * @return View
     */
    public function showDeletedAssets()
    {
        $userId = Auth::user()->id;
        $restoreAssetsData = $this->assets->getRestoreAssets($userId);
        $totalCount = $this->assets->calculateTotalCount($restoreAssetsData);

        $data = [
            'restoreAssetsData' => $restoreAssetsData,
            'totalCount' => $totalCount
        ];

        return view('assets.restore', $data);
    }

    /**
     * 削除された資産の復元
     *
     * @param string $id 復元する資産のID
     * @return \Illuminate\Http\RedirectResponse 成功または失敗メッセージを含むリダイレクトレスポンス
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException 指定されたIDの資産が見つからない場合
     * @throws \Exception データベース操作中にエラーが発生した場合
     */
    public function restoreAsset(string $id)
    {
        $asset = Asset::withTrashed()->findOrFail($id);

        try {
            DB::beginTransaction();
            $asset->restore();
            DB::commit();

            return back()->with('success-message', '資産の復元に成功しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return back()->with('error-message', '資産の復元に失敗しました。');
        }
    }
}
