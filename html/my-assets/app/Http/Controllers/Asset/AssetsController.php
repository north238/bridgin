<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCreateRequest;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Genre;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AssetsController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Asset::class, 'assets');
        
    }
    /**
     * 資産表示画面（ログイン済かつ作成したユーザーのみ）
     * 登録内容をテーブルで表示させる
     * todo: 表示させる日付の調整
     * ページネーション実装
     * ソート機能を実装
     */
    public function index()
    {
        // 直近の30日間のデータを取得
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        $userId = Auth::user()->id;

        $assets = Asset::where('user_id', $userId)
            ->with(['category:id,name'])
            // ->whereBetween('registration_date', [$startDate, $endDate])
            ->get();

        $totalAmount = Asset::where('user_id', $userId)
            // ->whereBetween('registration_date', ['2023-10-01', '2023-11-01'])
            ->sum('amount');

        return view('assets.index', compact('assets', 'totalAmount', 'userId'));
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
