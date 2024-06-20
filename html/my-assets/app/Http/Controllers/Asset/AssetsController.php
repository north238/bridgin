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
use Illuminate\Support\Facades\Log;

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
     * @param \Illuminate\Http\Request $request HTTPリクエスト
     * @return \Illuminate\Contracts\View 資産データを表示するビュー
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
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
     * @return \Illuminate\Contracts\View 資産登録画面を表示するビュー
     */
    public function create()
    {
        $formatDate = $this->assetService->getFormatDate();
        $genres = $this->genres->getGenreData()->get();
        $categories = $this->categories->getCategoriesData()->get();

        $data = [
            'genres' => $genres,
            'categories' => $categories,
            'formatDate' => $formatDate
        ];

        return view('assets.create', $data);
    }

    /**
     * 資産をデータベースに保存
     * @param \App\Http\Requests\AssetCreateRequest $request 資産登録時のデータ
     * @return \Illuminate\Http\RedirectResponse 登録成功時はダッシュボードへ遷移し、失敗時は元の画面へ戻る
     * @throws \Exception 資産の保存時に例外が発生した場合
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

            return redirect()->route('assets.dashboard')->with('success-message', __('create_success_message'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(__('create_error_log'), [
                'stack_trace' => $e->getTraceAsString(),
                'error_message' => $e->getMessage(),
                'method' => request()->method(),
                'parameters' => request()->all(),
            ]);
            return back()->withInput()->with('error-message', __('create_error_message'));
        }
    }

    /**
     * 資産詳細画面
     * @param string $id 資産ID
     * @return \Illuminate\Contracts\View ビューを返却
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;
        $assetData = $this->assets->getAssetData($id, $userId);
        $genres = $this->genres->getGenreData()->get();
        $categories = $this->categories->getCategoriesData()->get();

        $data = [
            'assetData' => $assetData,
            'genres' => $genres,
            'categories' => $categories,
        ];

        return view('assets.show', $data);
    }

    /**
     * 資産更新
     * @param \App\Http\Requests\AssetCreateRequest $request 資産作成リクエスト
     * @param string $id 資産ID
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンスを返す
     * @throws \Exception 資産の追加または更新時に例外が発生した場合
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

                return redirect()->back()->with('success-message', __('update_success_message'));
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error(__('update_error_log'), [
                    'stack_trace' => $e->getTraceAsString(),
                    'error_message' => $e->getMessage(),
                    'method' => request()->method(),
                    'parameters' => request()->all(),
                ]);
                return back()->withInput()->with('error-message', __('update_error_message'));
            }
            // 更新の場合の処理
        } else {
            try {
                $asset = Asset::find($id);
                $asset = $this->assetService->assetDataValidated($asset, $validated, $userId);

                DB::beginTransaction();
                $asset->save();
                DB::commit();

                return redirect()->back()->with('success-message', __('new_success_message'));
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error(__('new_error_log'), [
                    'stack_trace' => $e->getTraceAsString(),
                    'error_message' => $e->getMessage(),
                    'method' => request()->method(),
                    'parameters' => request()->all(),
                ]);
                return back()->withInput()->with('error-message', __('new_error_message'));
            }
        }
    }

    /**
     * 資産削除
     * @param string $id 資産ID
     * @return \Illuminate\Http\RedirectResponse リダイレクトレスポンスを返す
     * @throws \Exception 資産削除時に例外が発生した場合
     */
    public function destroy(string $id)
    {

        $asset = Asset::find($id);

        try {
            DB::beginTransaction();
            $asset->delete();
            DB::commit();

            return redirect()->route('assets.index')->with('success-message', __('delete_success_message'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(__('delete_error_log'), [
                'stack_trace' => $e->getTraceAsString(),
                'error_message' => $e->getMessage(),
                'method' => request()->method(),
                'parameters' => request()->all(),
            ]);
            return back()->withInput()->with('error-message', __('delete_error_message'));
        }
    }
}
