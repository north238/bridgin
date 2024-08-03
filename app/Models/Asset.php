<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name',
        'amount',
        'registration_date',
        'user_id',
        'category_id',
        'created_at',
        'updated_at',
        'asset_type_flg',
        'memo'
    ];

    /**
     * 指定されたユーザーIDに関連する全ての資産データを取得する
     * カテゴリテーブルとの結合を含む
     * 資産データは登録日付の降順でソートされる
     * @param int $userId 資産を取得するユーザーのID
     * @return \Illuminate\Database\Query\Builder 資産データを含むクエリ結果
     */
    public function getAssetsPagination($userId)
    {
        $result = Asset::query()
            ->join('categories as c', 'assets.category_id', '=', 'c.id')
            ->join('genres as g', 'c.genre_id', '=', 'g.id')
            ->select(['assets.*', 'assets.id as asset_id', 'c.name as category_name', 'g.id as genre_id', 'g.name as genre_name', 'g.risk_rank'])
            ->where('user_id', $userId)
            ->orderBy('registration_date', 'DESC');

        return $result;
    }

    /**
     * 指定されたユーザーIDに対応する資産データを取得する
     * カテゴリテーブルとの結合を含む
     * 日時の範囲指定がある場合、その範囲内のデータのみを取得する
     * 負債の表示/非表示の切り替えに対応
     * @param int        $userId 資産を取得するユーザーのID
     * @param array      $sort ソート条件（['order' => 'registration_date', 'type' => 'DESC']）
     * @param array|null $betweenMonthArray 日時の範囲指定（開始日と終了日の配列）。省略可能。
     * @param bool       $debutFlg 負債の表示/非表示フラグ。省略可能。
     * @return \Illuminate\Database\Query\Builder 資産データを含むクエリ結果
     */
    public function fetchUserAssets($userId, $sort, $betweenMonthArray = null, $debutFlg = false)
    {
        $sortOrder = $sort['order'];
        $sortType = $sort['type'];

        $result = Asset::query()
            ->join('categories as c', 'assets.category_id', '=', 'c.id')
            ->join('genres as g', 'c.genre_id', '=', 'g.id')
            ->join('chart_colors as mcc', 'g.color_id', '=', 'mcc.id')
            ->select(['assets.*', 'assets.id as asset_id', 'c.name as category_name', 'g.id as genre_id', 'g.name as genre_name', 'g.risk_rank', 'mcc.color_code'])
            ->where('user_id', $userId);

        if (isset($betweenMonthArray) === true) {
            $result->whereBetween('registration_date', $betweenMonthArray);
        }
        // 負債を非表示にする（ジャンルが「負債」のもの）
        if ($debutFlg === true) {
            $result->whereNotIn('g.id', [8]);
        }

        return $result->orderBy($sortOrder, $sortType);
    }

    /**
     * 資産データを指定した期間で絞り込む
     * @param \Illuminate\Support\Collection $data 資産データのコレクション
     * @param array $betweenMonthArray 取得したい年月の期間
     * @return \Illuminate\Database\Query\Builder 絞り込まれた資産データのコレクション
     */
    public function filterAssetsByDateRange($data, $betweenMonthArray)
    {
        return $data->whereBetween('registration_date', $betweenMonthArray);
    }

    /**
     * 資産データの負債を取り除く
     * @param \Illuminate\Support\Collection $data 資産データのコレクション
     * @return \Illuminate\Database\Query\Builder 絞り込まれた資産データのコレクション
     */
    public function filterAssetsByDebutData($data)
    {
        return $data->whereNot('genre_id', 8);
    }

    /**
     * 資産データから最新の登録日を取得する
     * @param  \Illuminate\Support\Collection $assetData 資産データのコレクション
     * @return string|null           最新の登録日（文字列形式）、データが空の場合はnullを返す
     */
    public function getLatestRegistrationDate($assetData)
    {
        return $assetData->pluck('registration_date')->first();
    }

    /**
     * 資産データの合計金額を計算する
     * @param  \Illuminate\Support\Collection $assetData 資産データのコレクション
     * @return float                 合計金額
     */
    public function calculateTotalAmount($assetData)
    {
        return $assetData->sum('amount');
    }

    /**
     * 資産データの総数を計算する
     * @param  \Illuminate\Support\Collection $assetData 資産データのコレクション
     * @return int                   資産の総数
     */
    public function calculateTotalCount($assetData)
    {
        return $assetData->count();
    }

    /**
     * 指定した資産を編集するときに使用する
     * @param int $id 資産ID
     * @param int $userId 資産を取得する際の並び替え基準
     * @return \App\Models\Asset|null 取得した資産データ、見つからない場合はnull
     */
    public function getAssetData($id, $userId)
    {
        $selectedColumns = ['assets.*', 'c.name as category_name',  'g.name as genre_name', 'g.id as genre_id'];
        $query = Asset::query()
            ->join('categories as c', 'assets.category_id', '=', 'c.id')
            ->join('genres as g', 'c.genre_id', '=', 'g.id')
            ->select($selectedColumns)
            ->where('assets.user_id', $userId)
            ->where('assets.id', $id)
            ->first();

        return $query;
    }

    /**
     * 負債データの取得
     * @param \Illuminate\Database\Eloquent\Builder $assetData
     * @param array[Carbon] $betweenMonthArray
     * @return \Illuminate\Database\Query\Builder $result ユーザーの負債額データのコレクション
     */
    public function getDebutAssetsData($assetData, $betweenMonthArray = null)
    {
        $result =
            $assetData->where('genre_id', 8);

        if (!empty($betweenMonthArray)) {
            $result = $result->whereBetween('registration_date', $betweenMonthArray);
        }

        return $result;
    }

    /**
     * 削除された資産データの取得
     * @param int $userId 資産を取得する際の並び替え基準
     * @return \App\Models\Asset|null 取得した資産データ、見つからない場合はnull
     */
    public function getRestoreAssets($userId)
    {
        $selectedColumns = ['assets.*', 'c.name as category_name',  'g.name as genre_name', 'g.id as genre_id'];
        $query = Asset::onlyTrashed()
            ->join('categories as c', 'assets.category_id', '=', 'c.id')
            ->join('genres as g', 'c.genre_id', '=', 'g.id')
            ->select($selectedColumns)
            ->where('user_id', $userId)
            ->orderBy('deleted_at', 'DESC')
            ->get();

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function assetChanges(): HasMany
    {
        return $this->hasMany(AssetChange::class);
    }
}
