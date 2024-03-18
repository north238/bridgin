<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCreateRequest;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    private $user;
    private $assets;
    private $categories;
    private $genres;

    public function __construct(Asset $assets, )
    {
        $assets = $this->assets;
        // $this->authorizeResource(Asset::class, 'assets');
        if(Auth::check()){
            $this->user = Auth::user()->id;
        }
    }

    /**
     * 資産表示画面（ログイン済かつ作成したユーザーのみ）
     * 登録内容をテーブルで表示させる
     * ソート機能を実装
     * todo:当月にデータがない場合データが表示されない
     * →データがない場合でも前月ボタンを表示させる
     * 負債の表示切替機能
     * →トグルボタンで切り替える
     */
    public function index()
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
            ->orderBy('name', 'ASC')
            ->get();

        // array_multisort($sort, SORT_DESC, $assets);

        $totalAmount = $assets->sum('amount');

        $assetsByMonth = $assets->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        if($assets->count() === 0) {
            return redirect()->route('assets.create')->with('new-create-message', 'あなたの新しい資産を追加しましょう');
        }
        // データがない場合の処理（今月はないが過去のデータはある場合）
        // 全月のデータをいったん取得
        // →それから送信するデータを仕分ける
        // 今月のデータがからの場合の処理
        // Ajaxを使ってデータをコントローラに送信している
        // だからフォームから送信するデータがないとエラーになる
        // 代案）空の場合の処理を分ける
        // または同じ処理で特定の場合には空を渡す処理にする

        return view('assets.index', compact('assets', 'assetsByMonth', 'totalAmount', 'userId', 'formatDate', 'assetMinDate'));
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
