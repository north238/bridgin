<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCreateRequest;
use App\Models\Asset;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    private $userId;
    private $assetMinDate;

    public function __construct()
    {
        // $this->authorizeResource(Asset::class, 'assets');
        if(Auth::check()){
            $this->userId = Auth::user()->id;
        }
    }

    /**
     * 資産表示画面（ログイン済かつ作成したユーザーのみ）
     * 登録内容をテーブルで表示させる
     * ソート機能を実装
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $formatDate = Carbon::now()->format('Y-m');
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $assetMinDate = Asset::query()
            ->where('user_id', $userId)
            ->min('registration_date');
        $assetMinDate = Carbon::parse($assetMinDate)->format('Y-m');

        $assets = Asset::query()
            ->where('user_id', $userId)
            ->with(['category:id,name'])
            ->whereBetween('registration_date', [$startDate, $endDate])
            ->get();

        $totalAmount = $assets->sum('amount');

        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return view('assets.index', compact('assets', 'assetsByMonth', 'totalAmount', 'userId', 'formatDate', 'assetMinDate'));
    }

    // テーブル上部にある日時のページネーション
    // ajaxによる非同期処理
    // クリックされたボタンにより表示する月を変更
    public function monthPaginationAjax(Request $request)
    {
        $requestData = $request->all();
        $userId = Auth::user()->id;
        $clickedBtn = $requestData['clicked-btn'];
        $formatDate = Carbon::now()->format('Y-m');
        $prevMonthData = Carbon::parse($requestData['prev-month'])->format('Y-m-d');
        $nextMonthData = Carbon::parse($requestData['next-month'])->format('Y-m-d');

        if ($clickedBtn === 'prev-month-btn') {
            // 前月
            $betweenMonthArray = [
                Carbon::parse($prevMonthData)->startOfMonth(),
                Carbon::parse($prevMonthData)->endOfMonth()
            ];
        } elseif ($clickedBtn === 'next-month-btn') {
            // 翌月
            $betweenMonthArray = [
                Carbon::parse($nextMonthData)->startOfMonth(),
                Carbon::parse($nextMonthData)->endOfMonth()
            ];
        } else {
            // 今月
            $betweenMonthArray = [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ];
        }

        $assets = Asset::query()
            ->where('user_id', $userId)
            ->with(['category:id,name'])
            ->whereBetween('registration_date', [$betweenMonthArray])
            ->get();
        $totalAmount = $assets->sum('amount');
        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return view('assets.ajax_index', compact('assetsByMonth', 'totalAmount', 'requestData', 'formatDate'))->render();
    }

    /**
     * 資産登録画面
     * todo:: ジャンル指定すると対応したカテゴリが
     * todo:: 出現するロジックを追加したい
     */
    public function create()
    {
        $categories = Category::query()->with(['genre:id,name'])->distinct()->get();
        return view('assets.create', compact('categories'));
    }

    /**
     * 資産をデータベースに保存
     * todo:: データベースに資産が登録してある場合表示させる
     * todo:: 文字を入力してもvalidationが消えない
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
     * todo:: カテゴリIDとジャンルIDの紐づけ
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;

        $assetData = Asset::query()
            ->join('categories as c', 'assets.category_id', '=', 'c.id')
            ->join('genres as g', 'c.genre_id', '=', 'g.id')
            ->select('assets.*', 'c.name as category_name',  'g.name as genre_name', 'g.id as genre_id')
            ->where('assets.user_id', $userId)
            ->where('assets.id', $id)
            ->first();

        $categories = Category::query()
            ->with('genre')
            ->get();

        return view('assets.show', compact('assetData', 'categories'));
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
     * 論理削除のため検索可能
     * todo: 削除したものを復元するロジックを考える
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
}
