<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCreateRequest;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\AssetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AssetsController extends Controller
{
    private $assets;
    private $genres;
    private $categories;
    private $assetService;

    public function __construct(
        Asset $assets,
        Genre $genres,
        Category $categories,
        AssetService $assetService
    ) {
        $this->assets = $assets;
        $this->genres = $genres;
        $this->categories = $categories;
        $this->assetService = $assetService;
    }

    /**
     * 資産表示画面
     * ユーザーがログインしており、自身が作成したユーザーの場合にのみアクセス可能
     * @param  Request $request HTTPリクエスト
     * @return View             資産データを表示するビュー
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $formatDate = $this->assetService->getFormatDate();
        $sort = ['order' => 'registration_date', 'type' => 'DESC'];

        $debutStatus = $request->input('debutStatus');
        // 負債データの表示/非表示を切り替える
        $assetAllData = $this->assetService->switchDebutVisibility($debutStatus, $userId, $sort);

        // 資産データの最新の年月を取得
        $latestMonthDate = $this->assets->getLatestRegistrationDate($assetAllData);
        $betweenMonthArray = $this->assetService->createSearchTargetMonth($latestMonthDate);
        $assetsData = $this->assets->filterAssetsByDateRange($assetAllData, $betweenMonthArray)->get();
        $totalAmount = $this->assets->calculateTotalAmount($assetsData);
        $totalCount = $this->assets->calculateTotalCount($assetsData);

        $data = [
            'assetsData' => $assetsData,
            'totalAmount' => $totalAmount,
            'totalCount' => $totalCount,
            'latestMonthDate' => $latestMonthDate,
            'debutStatus' => $debutStatus
        ];

        return view('assets.index', $data);
    }

    /**
     * 資産登録画面
     */
    public function create()
    {
        $formatDate = $this->assetService->getFormatDate();
        $genres = $this->genres->getGenreData()->get();
        $categories = $this->categories->getCategoriesData()->get();

        return view('assets.create', compact('genres', 'categories', 'formatDate'));
    }

    /**
     * 資産をデータベースに保存
     * フォームバリデーションを導入する
     */
    public function store(AssetCreateRequest $request)
    {
        $userId = Auth::user()->id;
        $asset = $this->assets;
        $validated = $request->validated();
        $asset = $this->assetService->assetDataValidated($asset, $validated, $userId);

        try {
            DB::beginTransaction();
            $asset->save();
            DB::commit();

            return redirect()->route('assets.index')->with('success-message', '資産の登録に成功しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error-message', '資産の登録に失敗しました。' . $e->getMessage());
        }
    }

    /**
     * 資産詳細画面
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;
        $assetData = $this->assets->getAssetData($id, $userId);
        $genres = $this->genres->getGenreData()->get();
        $categories = $this->categories->getCategoriesData()->get();

        return view('assets.show', compact('assetData', 'categories', 'genres'));
    }

    /**
     * 資産更新
     */
    public function update(AssetCreateRequest $request, string $id)
    {
        $userId = Auth::user()->id;
        $validated = $request->validated();
        $changedTypeFlg = $request->input('changed_type_flg');

        // 追加の場合の処理
        if ($changedTypeFlg == 1) {
            try {
                $asset = $this->assets;
                $asset = $this->assetService->assetDataValidated($asset, $validated, $userId);

                DB::beginTransaction();
                $asset->save();
                DB::commit();

                return redirect()->route('assets.index')->with('success-message', '資産の追加に成功しました。');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withInput()->with('error-message', '資産の追加に失敗しました。' . $e->getMessage());
            }
            // 更新の場合の処理
        } else {
            try {
                $asset = Asset::find($id);
                $asset = $this->assetService->assetDataValidated($asset, $validated, $userId);

                DB::beginTransaction();
                $asset->save();
                DB::commit();

                return redirect()->route('assets.index')->with('success-message', '資産の更新に成功しました。');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withInput()->with('error-message', '資産の更新に失敗しました。' . $e->getMessage());
            }
        }
    }

    /**
     * 資産削除
     */
    public function destroy(string $id)
    {

        $asset = Asset::find($id);

        try {
            DB::beginTransaction();
            $asset->delete();
            DB::commit();

            return redirect()->route('assets.index')->with('success-message', '資産を削除しました。削除されたデータは保存されます。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error-message', '資産の削除に失敗しました。' . $e->getMessage());
        }
    }
}
