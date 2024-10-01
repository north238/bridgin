<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Asset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AssetService
{

    private $assets;

    public function __construct(
        Asset $assets,
    ) {
        $this->assets = $assets;
    }

    /**
     * 資産を年月でグループ化する
     * @param $data 資産のコレクション
     * @return \Illuminate\Support\Collection 年月でグループ化された結果
     */
    public function groupByMonthOfRegistration($data)
    {
        $assetData = $data->get();
        $result = $assetData->groupBy(function ($asset) {
            return Carbon::parse($asset->registration_date)->format('Y-m');
        });

        return $result;
    }

    /**
     * 登録された資産データに年月がない場合に補完する
     * @param \Illuminate\Support\Collection $data
     * @param array $allMonths 年月の配列
     * @return \Illuminate\Support\Collection すべての年月が補完されたデータ, 年月で並び替え（キーを昇順に）
     */
    public function registeredAssetDataComplement($data, $allMonths)
    {
        $result = $this->groupByMonthOfRegistration($data);

        // 今年の1月から12月までの範囲を設定
        $startMonth = Carbon::create(2024, 1, 1);  // 2024年1月
        $endMonth = Carbon::create(2024, 12, 1);   // 2024年12月

        // 全ての月をループし、不足している月を補完
        while ($startMonth->lessThanOrEqualTo($endMonth)) {
            $formattedMonth = $startMonth->format('Y-m'); // 例えば "2024-09"

            // $result に月が存在しない場合は 0 のデータで補完
            if (!isset($result[$formattedMonth])) {
                $result[$formattedMonth] = collect([['registration_date' => $formattedMonth, 'amount' => 0]]);
            }

            // 次の月へ進む
            $startMonth->addMonth();
        }

        return $result->sortKeys();
    }


    /**
     * 資産グループの合計金額と資産数を計算して新しい構造で返す
     * @param \Illuminate\Support\Collection $data 資産データのコレクション
     * @return \Illuminate\Support\Collection 合計金額と資産数を含む新しい構造のコレクション
     */
    public function processAssetGroups($data)
    {
        $result = $data->map(function ($group) {
            $totalAmount = $group->sum('amount');   // 合計金額を計算
            $assetCount = $group->count();          // 資産数をカウント

            return [
                'totalAmount' => $totalAmount,
                'assetCount' => $assetCount,
                'data' => $group
            ];
        });

        return $result;
    }

    /**
     * 前月比率を計算して返却する
     * @param \Illuminate\Support\Collection $data 資産データのコレクション。キーは年月（'Y-m'形式）で、値は各月の合計金額と資産数。
     * @return \Illuminate\Support\Collection 前月比率を含む新しいコレクション。各月のデータには、以下のキーが含まれます：
     * - 'month'：年月（'Y-m'形式）
     * - 'totalAmount'：その月の合計金額
     * - 'assetCount'：その月の資産数
     * - 'increaseAndDecreaseAmount'：増減額
     * - 'monthOverMonthRatio'：前月比率
     * - 'ratioClass'：前月比率に基づいたクラス（'positive'、'negative'、または'even'）
     */
    public function calcMonthOverMonthRatios($data)
    {
        $months = $data->keys()->sort();
        $monthOverMonthRatios = new Collection();
        $previousMonthTotalAmount = 0;

        foreach ($months as $month) {
            $currentMonthData = $data->get($month);
            $currentMonthTotalAmount = $currentMonthData['totalAmount'];
            $assetCount = $currentMonthData['assetCount'];
            $increaseAndDecreaseAmount = $currentMonthTotalAmount - $previousMonthTotalAmount;

            if ($previousMonthTotalAmount !== 0) {
                // 前月比率を計算
                $monthOverMonthRatio = round($increaseAndDecreaseAmount / $previousMonthTotalAmount * 100, 2);
                // 計算結果によってクラスを付与（フロント側で色を分けたいため）
                $ratioClass = $monthOverMonthRatio >= 0 ? 'positive' : 'negative';
                $monthOverMonthRatios->put($month, [
                    'month' => $month,
                    'totalAmount' => $currentMonthTotalAmount,
                    'assetCount' => $assetCount,
                    'increaseAndDecreaseAmount' => $increaseAndDecreaseAmount,
                    'monthOverMonthRatio' => $monthOverMonthRatio,
                    'ratioClass' => $ratioClass
                ]);
            } else {
                // 最初の月は前月比率を計算しない
                $monthOverMonthRatios->put($month, [
                    'month' => $month,
                    'totalAmount' => $currentMonthTotalAmount,
                    'assetCount' => $assetCount,
                    'increaseAndDecreaseAmount' => $increaseAndDecreaseAmount,
                    'monthOverMonthRatio' => 0,
                    'ratioClass' => 'even'
                ]);
            }
            // 最新月の合計金額を次の月の前月合計金額として設定
            $previousMonthTotalAmount = $currentMonthTotalAmount;
        }

        return $monthOverMonthRatios;
    }

    /**
     * 最新月の増減額を取得する
     * @param  \Illuminate\Support\Collection $assetsAllData 資産データのコレクション
     * @param  string $latestMonthDate 最新の年月
     * @param  int $monthlyTotalAmount 月間の合計金額
     * @return int $increaseDecreaseAmount 計算された資産増減額
     */
    public function getLatestMonthIncreaseDecreaseAmount($assetsAllData, $latestMonthDate, $monthlyTotalAmount)
    {
        // 資産データがなければ0を返却
        if (empty($assetsAllData) === true) {
            return 0;
        }
        // ひと月前の年月を取得
        $previousMonthDate = $this->getPreviousMonthDate($latestMonthDate);
        // ひと月前のデータを取得
        $betweenMonthArray = $this->createSearchTargetMonth($previousMonthDate);
        $previousMonthData = $this->assets->filterAssetsByDateRange($assetsAllData, $betweenMonthArray);
        // ひと月前のデータがない場合の条件分岐
        if (!empty($previousMonthData) === true) {
            $previousMonthAmount = $this->assets->calculateTotalAmount($previousMonthData);
        } else {
            $previousMonthAmount = 0;
        }
        $increaseDecreaseAmount =
            $monthlyTotalAmount - $previousMonthAmount;

        return $increaseDecreaseAmount;
    }

    /**
     * 負債合計額を取得する
     * @param  int  $userId    資産を取得するユーザーのID
     * @param  bool $debutFlg  負債を判断するためのフラグ
     * @return \Illuminate\Support\Collection 今月の負債額の合計
     */
    public function debutAmountDisplay($userId, $sort, $latestMonthDate)
    {
        $assetData = $this->assets->fetchUserAssets($userId, $sort);
        $betweenMonthArray = $this->createSearchTargetMonth($latestMonthDate);
        $debutAssetData = $this->assets->getDebutAssetsData($assetData, $betweenMonthArray);
        $result = $debutAssetData->sum('amount');

        return $result;
    }

    /**
     * 負債の表示/非表示切替
     * @param int 　$debutStatus 負債を表示するかどうかを示すステータス
     * @param int 　$userId 資産を取得するユーザーのID
     * @param array $sort 資産を取得する際の並び替え基準
     * @return \Illuminate\Support\Collection ステータスに応じて負債の表示/非表示が切り替えられた資産のコレクション
     */
    public function switchDebutVisibility($debutStatus, $userId, $sort)
    {
        if (isset($debutStatus) === true && $debutStatus === 1) {
            //　負債を非表示にする処理（ジャンルが負債のものを除外）
            $debutFlg = true;
            $assetAllData = $this->assets->fetchUserAssets($userId, $sort, null, $debutFlg);
        } else {
            $assetAllData = $this->assets->fetchUserAssets($userId, $sort, null);
        }

        return $assetAllData;
    }

    /**
     * 現在の年月を取得する（データ取得時のwhereBetweenで使用）
     * @return array [Carbon] 現在の年月の範囲
     */
    public function getCurrentMonth()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->startOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        return $betweenMonthArray;
    }

    /**
     * 取得した日時から検索対象の年月を作成
     * @param  string $date
     * @return array [Carbon] 現在の年月の範囲
     */
    public function createSearchTargetMonth($date)
    {
        $startDate = Carbon::parse($date)->startOfMonth();
        $endDate = Carbon::parse($date)->endOfMonth();
        $betweenMonthArray = [$startDate, $endDate];
        return $betweenMonthArray;
    }

    /**
     * 取得した年から検索対象の年月を作成
     * @param  string $year
     * @return array [Carbon] 現在の年月の範囲
     */
    public function getStartAndEndOfYear($year)
    {
        $startOfYear = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $endOfYear = Carbon::createFromDate($year, 12, 31)->endOfDay();
        $betweenMonthArray = [$startOfYear, $endOfYear];
        return $betweenMonthArray;
    }

    /**
     * 最新の年月日を整形（2024-05-01 -> 20240501)
     * - csvのファイル名に使用する
     * @param string $date 年月日
     * @return string 整形された年月日
     */
    public function getCsvFilename($date)
    {
        return str_replace('-', '', $date);
    }

    /**
     * 受け取った年月日をフォーマット
     * @param  string $date 年月日
     * @return string 変換された年月
     */
    public function getFormatYearMonth($date)
    {
        if ($date === null) {
            $date = Carbon::now();
        }
        return date('Y年m月', strtotime($date));
    }

    /**
     * 現在の日付を指定されたフォーマットで取得
     *
     * @return string フォーマットされた現在の日付
     */
    public function getFormatDate()
    {
        return Carbon::now()->format('Y-m-d');
    }

    /**
     * 取得した年月を変換する
     * @param  string $date
     * @return string $formatDate フォーマットされた年月
     */
    public function getFormatMonthDate($date)
    {
        $carbonDate = Carbon::createFromFormat('Y-m', $date);
        $formatDate = $carbonDate->format('Y-m-01');

        return $formatDate;
    }

    /**
     * ひと月前の日付に変換する
     * - 翌月に取得したい日がない場合にズレが発生するため記述
     * - 例) 2024-10-31 -> 2024-10-01を取得してしまう
     * - https://qiita.com/gungungggun/items/76e9a2a28f34a16570ff
     *
     * @param  string $date 年月日を取得
     * @return string $formatDate フォーマットされた年月
     */
    public function getPreviousMonthDate($date)
    {
        $carbonDate = Carbon::parse($date)->settings(['monthOverflow' => false]);
        $previousMonthDate =
            $carbonDate->subMonth()->format('Y-m-01');

        return $previousMonthDate;
    }

    /**
     * 最大・最小月の取得
     * @param  string $date 年月日を取得
     * @return object $formatDate フォーマットされた年月
     */
    public function formaDate($date)
    {
        return Carbon::parse($date)->settings(['monthOverflow' => false])->startOfMonth();
    }

    /**
     * 資産データのバリデーション
     *
     * @param App\Models\Asset $asset 資産データ
     * @param array $validated バリデーションされた配列
     * @param int $userId 資産を登録するユーザーのID
     * @return App\Models\Asset バリデーション済みの資産データ
     */
    public function assetDataValidated($asset, $validated, $userId)
    {
        $asset->name = $validated['name'];
        $asset->amount = $this->validationAmount($validated);
        $asset->registration_date = $validated['registration_date'];
        $asset->category_id = $validated['category_id'];
        $asset->asset_type_flg = $validated['asset_type_flg'];
        $asset->user_id = $userId;

        return $asset;
    }

    /**
     * 金額のバリデーションおよび整形
     *
     * @param array $validated バリデーションされた配列
     * @throws \Illuminate\Validation\ValidationException 入力データがバリデーションルールに違反している場合
     * @return int 整形後の金額 (カンマを除去した数値)
     */
    private function validationAmount($validated)
    {
        $amount = str_replace(',', '', $validated['amount']);

        if ($validated['genre_id'] != 8 && $amount < 0) {
            throw ValidationException::withMessages(['amount' => 'このジャンルではマイナスの値は許可されていません。']);
        }

        if ($validated['genre_id'] == 8 && $amount > 0) {
            throw ValidationException::withMessages(['amount' => 'このジャンルではマイナスの数値を入力して下さい。']);
        }

        return $amount;
    }

    /**
     * 資産データ削除のリダイレクトするURLを取得
     * @param Illuminate\Http\Request $request リクエストオブジェクト
     * @return string $parseUrl 整形された相対パス
     */
    public function generateRedirectUrl($request)
    {
        // リダイレクト対象のURLを指定
        $allowedUrls = [
            route('assets.dashboard'),
            route('assets.index')
        ];

        $redirectUrl = $request->input('redirect_to', route('assets.dashboard'));
        if (!in_array($redirectUrl, $allowedUrls)) {
            $redirectUrl = route('assets.dashboard');
        }
        // 相対パスを取得
        $parsedUrl = parse_url($redirectUrl, PHP_URL_PATH);
        if (empty($parsedUrl)) {
            Log::error(__('nothing_url_error'), ['parsedUrl' => $parsedUrl]);
            abort(404);
        }

        return $parsedUrl;
    }
}
