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
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $formatDate = Carbon::now()->format('Y-m');
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        $sortData = ['order' => 'name', 'type' => 'ASC'];

        $assetMinDate = $this->assets->minAsset($userId);
        $assetMinDate = Carbon::parse($assetMinDate)->format('Y-m');

        $assetsAllData = $this->assets->assetsAllData($userId, $sortData);
        if ($assetsAllData->count() === 0) {
            return redirect()->route('assets.create')->with('new-create-message', 'あなたの新しい資産を追加しましょう');
        }

        $assets = $this->assets->assetsQuery($userId, $betweenMonthArray, $sortData);
        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        $totalAmount = $assets->sum('amount');

        session()->put('month-data', $betweenMonthArray);

        return view('assets.index', compact('assets', 'assetsByMonth', 'totalAmount', 'userId', 'formatDate', 'assetMinDate', 'sortData'));
    }

    /**
     * 資産登録画面
     */
    public function create()
    {
        $genres = Genre::query()->get();
        $categories = Category::query()->with(['genre:id,name'])->get();
        return view('assets.create', compact('genres', 'categories'));
    }

    /**
     * 資産をデータベースに保存
     * todo:: 文字を入力してもvalidationが消えない
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
        $asset->user_id = $userId;
        try {
            DB::beginTransaction();
            $asset->save();
            DB::commit();

            return redirect()->route('assets.index')->with('success-message', '登録に成功しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error-message', '登録に失敗しました。' . $e->getMessage());
        }
    }

    /**
     * 資産詳細画面
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;
        $query = ['assets.*', 'c.name as category_name',  'g.name as genre_name', 'g.id as genre_id'];

        $assetData = Asset::query()
            ->join('categories as c', 'assets.category_id', '=', 'c.id')
            ->join('genres as g', 'c.genre_id', '=', 'g.id')
            ->select($query)
            ->where('assets.user_id', $userId)
            ->where('assets.id', $id)
            ->first();

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
        $asset = Asset::find($id);
        $validated = $request->validated();
        $asset->name = $validated['name'];
        $asset->amount = $validated['amount'];
        $asset->registration_date = $validated['registration_date'];
        $asset->category_id = $validated['category_id'];
        $asset->user_id = $userId;
        try {
            DB::beginTransaction();
            $asset->save();
            DB::commit();

            return redirect()->route('assets.index')->with('success-message', '更新に成功しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error-message', '更新に失敗しました。' . $e->getMessage());
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

            return redirect()->route('assets.index')->with('success-message', '削除に成功しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error-message', '削除に失敗しました。' . $e->getMessage());
        }
    }

    // 理論削除されたデータの復元
    // todo:どの画面に実装するのか検討
    // →検索して表示する画面
    // →どこから検索を走らせるのか？
    public function restore(string $id)
    {
        $asset = Asset::withTrashed()->findOrFail($id);

        try {
            DB::beginTransaction();
            $asset->restore();
            DB::commit();

            return redirect()->back()->with('success-message', '復元に成功しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error-message', '復元に失敗しました。' . $e->getMessage());
        }
    }
}
