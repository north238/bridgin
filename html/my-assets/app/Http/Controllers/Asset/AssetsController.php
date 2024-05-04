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
     * 資産表示画面（ログイン済かつ作成したユーザーのみ）
     * 登録内容をテーブルで表示させる
     * @return View 資産データを表示させる
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $formatDate = $this->assetService->getFormatDate();
        if (isset($request->sort) === true) {
            $sort = $request->sort;
        } else {
            $sort = ['order' => 'registration_date', 'type' => 'DESC'];
        }

        $debutStatus = $request->input('debutStatus');
        // 負債データの表示/非表示を切り替える
        $assetAllData = $this->assetService->switchDebutVisibility($debutStatus, $userId, $sort);

        // 資産データの最新の年月を取得
        $latestMonthDate = $assetAllData->pluck('registration_date')->first();
        $betweenMonthArray = $this->assetService->createSearchTargetMonth($latestMonthDate);
        $assetsData = $this->assets->filterAssetsByDateRange($assetAllData, $betweenMonthArray)->get();
        $totalAmount = $assetsData->sum('amount');

        $data = [
            'assetsData' => $assetsData,
            'totalAmount' => $totalAmount,
            'formatDate' => $formatDate,
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
        $categories = Category::query()->with(['genre:id,name'])->get();
        return view('assets.create', compact('genres', 'categories', 'formatDate'));
    }

    /**
     * 資産をデータベースに保存
     * TODO: 文字を入力してもvalidationが消えない
     * フォームバリデーションを導入する
     */
    public function store(AssetCreateRequest $request)
    {
        $userId = Auth::user()->id;
        $asset = $this->assetService->assetDataValidated($request, $userId);
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
        $changedTypeFlg = $request->input('changed_type_flg');
        $validated = $request->validated();

        // 追加の場合の処理
        if ($changedTypeFlg == 1) {
            try {
                DB::beginTransaction();
                $asset = $this->assetService->assetDataValidated($request, $userId);
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
                DB::beginTransaction();
                $asset = Asset::find($id);
                $asset->name = $validated['name'];
                $asset->amount = $validated['amount'];
                $asset->registration_date = $validated['registration_date'];
                $asset->category_id = $validated['category_id'];
                $asset->asset_type_flg = $validated['asset_type_flg'];
                $asset->user_id = $userId;
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
