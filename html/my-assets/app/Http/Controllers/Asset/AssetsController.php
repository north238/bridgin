<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCreateRequest;
use App\Models\Asset;
use App\Models\User;
use App\Models\Category;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\AssetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route as FacadesRoute;

class AssetsController extends Controller
{
    private $users;
    private $assets;
    private $assetService;

    public function __construct(
        Asset $assets,
        User $users,
        AssetService $assetService
    ) {
        $this->assets = $assets;
        $this->users = $users;
        $this->assetService = $assetService;
        // $this->authorizeResource(Asset::class, 'assets');
    }

    /**
     * 資産表示画面（ログイン済かつ作成したユーザーのみ）
     * 登録内容をテーブルで表示させる
     * @return View 資産データを表示させる
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $formatDate = Carbon::now()->format('Y-m');
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        if (isset($request->sort) === true) {
            $sort = $request->sort;
        } else {
            $sort = ['order' => 'category_id', 'type' => 'DESC'];
        }

        $debutStatus = $request->input('debutStatus');
        if (isset($debutStatus) === true && $debutStatus === 1) {
            //　負債を非表示にする処理（ジャンルが負債のものを除外）
            $debutFlg = true;
            $assets = $this->assets->fetchUserAssets($userId, $betweenMonthArray, $sort, $debutFlg);
        } else {
            $assets = $this->assets->fetchUserAssets($userId, $betweenMonthArray, $sort);
        }

        $assetMinDate = $this->assets->minAsset($userId);
        $assetMinDate = Carbon::parse($assetMinDate)->format('Y-m');

        $assetsAllData = $this->assets->getAssetsAllData($userId, $sort);
        if ($assetsAllData->count() === 0) {
            return redirect()->route('assets.create')->with('new-create-message', 'あなたの新しい資産を追加しましょう');
        }

        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        $totalAmount = $assets->sum('amount');

        Session::put('monthData', $betweenMonthArray);
        Session::put('sortData', $sort);

        return view('assets.index', ['assets' => $assets, 'assetsByMonth' => $assetsByMonth, 'totalAmount' => $totalAmount, 'userId' => $userId, 'formatDate' => $formatDate, 'assetMinDate' => $assetMinDate, 'sort' => $sort, 'debutStatus' => $debutStatus]);
    }

    /**
     * 資産登録画面
     */
    public function create()
    {
        $formatDate = Carbon::now()->format('Y-m-d');
        $genres = Genre::query()->get();
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
        $asset = new Asset();
        $validated = $request->validated();
        $asset->name = $validated['name'];
        $asset->amount = $validated['amount'];
        $asset->registration_date = $validated['registration_date'];
        $asset->category_id = $validated['category_id'];
        $asset->asset_type_flg = $validated['asset_type_flg'];
        $asset->user_id = $userId;
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
        $genres = Genre::query()->get();
        $categories = Category::query()
            ->with(['genre:id,name'])
            ->get();

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
                $asset = new Asset();
                $asset->name = $validated['name'];
                $asset->amount = $validated['amount'];
                $asset->registration_date = $validated['registration_date'];
                $asset->category_id = $validated['category_id'];
                $asset->asset_type_flg = $validated['asset_type_flg'];
                $asset->user_id = $userId;
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
