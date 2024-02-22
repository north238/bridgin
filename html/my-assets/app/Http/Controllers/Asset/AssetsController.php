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
     * 表示させる日付の調整
     */
    public function index()
    {
        // 直近の30日間のデータを取得
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        $user = Auth::user();

        $assets = Asset::where('user_id', $user->id)
            ->with(['category:id,name'])
            // ->whereBetween('registration_date', [$startDate, $endDate])
            ->get();

        $totalAmount = Asset::where('user_id', $user->id)
            // ->whereBetween('registration_date', ['2023-10-01', '2023-11-01'])
            ->sum('amount');

        return view('assets.index', compact('assets', 'totalAmount', 'user'));
    }

    /**
     * 資産登録画面
     * ジャンル指定すると対応したカテゴリが
     * 出現するロジックを追加したい
     * 登録するボタン背景色バグ
     */
    public function create()
    {
        $categories = Category::with(['genre:id,name'])->get();
        return view('assets.create', compact('categories'));
    }

    /**
     * 資産をデータベースに保存
     * データベースに資産が登録してある場合表示させる
     * 文字を入力してもvalidationが消えない
     */
    public function store(AssetCreateRequest $request)
    {
        $user = auth()->id();
        $asset = new Asset();
        $validated = $request->validated();
        $asset->name = $validated['name'];
        $asset->amount = $validated['amount'];
        $asset->registration_date = $validated['registration_date'];
        $asset->category_id = $validated['category_id'];
        $asset->user_id = $user;
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
     * カテゴリIDとジャンルIDの紐づけ
     */
    public function show(string $id)
    {
        $user = auth()->id();
        $assetData = Asset::with(['category:id,name'])
            ->where('user_id', $user)
            ->where('id', $id)
            ->get();
        $categories = Category::with(['genre:id,name'])->get();
        return view('assets.show', compact('assetData', 'categories'));
    }

    /**
     * 資産編集画面表示
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * 資産更新
     */
    public function update(Request $request, string $id)
    {
        // if (!Gate::allows('update-asset')) {
        //     abort(403);
        // }
    }

    /**
     * 資産削除
     */
    public function destroy(string $id)
    {
        //
    }
}
