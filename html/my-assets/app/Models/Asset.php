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
        'asset_type_flg'
    ];

    /**
     * 資産全件出力
     * @param  int   $userId
     * @return query $result
     */
    public function getAssetsAllData($userId)
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
     * カテゴリテーブルとJoinしたものを全件取得
     * 日時の指定（いつから、いつまで）
     * 負債の表示・非表示の切り替えに対応
     * @param  int    $userID
     * @param  array  $sort
     * @param  bool   $debutFlg
     * @return query  $result
     */
    public function fetchUserAssets($userId, $sort, $betweenMonthArray = null, $debutFlg = false)
    {
        $sortOrder = $sort['order'];
        $sortType = $sort['type'];

        $result = Asset::query()
            ->join('categories as c', 'assets.category_id', '=', 'c.id')
            ->join('genres as g', 'c.genre_id', '=', 'g.id')
            ->select(['assets.*', 'assets.id as asset_id', 'c.name as category_name', 'g.id as genre_id', 'g.name as genre_name', 'g.risk_rank'])
            ->where('user_id', $userId);

        if(isset($betweenMonthArray) === true) {
            $result->whereBetween('registration_date', $betweenMonthArray);
        }
        // 負債を非表示にする（ジャンルが「負債」のもの）
        if ($debutFlg === true) {
            $result->whereNotIn('g.id', [8]);
        }

        return $result->orderBy($sortOrder, $sortType);
    }

    /**
     * 資産を指定した期間で絞る
     */
    public function filterAssetsByDateRange($data, $betweenMonthArray)
    {
        return $data->whereBetween('registration_date', $betweenMonthArray);
    }

    /**
     * データの最小値を取得
     * @param  int    $userId
     * @return string $result
     */
    public function minAsset($userId)
    {
        $result = Asset::query()
            ->where('user_id', $userId)
            ->min('registration_date');

        return $result;
    }

    /**
     * 指定した資産を編集するときに使用する
     * @param  int   $id
     * @param  int   $userId
     * @return query $query
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
     * 負債額データの取得
     * @param  int        $userId
     * @param  Carbon     $betweenMonthArray
     * @return Collection $result ユーザーの負債額データのコレクション
     */
    public function getDebutAssetsData($userId, $betweenMonthArray)
    {
        $sort =
            ['order' => 'registration_date', 'type' => 'DESC'];
        $assetData = $this->fetchUserAssets($userId, $sort, $betweenMonthArray);
        $result = $assetData->whereIn('g.id', [8]);

        return $result;
    }

    /**
     * 削除された資産データの取得
     * @param  int   $userId
     * @return array $query
     */
    public function getRestoreAssets($userId)
    {
        $query = Asset::onlyTrashed()
            ->where('user_id', $userId)
            ->get();

        return $query;
    }

    /**
     * 資産推移を表示するデータの取得
     * 年間表示の場合
     * 必要なデータ:（年月、資産名、資産額、ユーザー）
     * グラフ: 積みあげ棒グラフ（各資産データが積みあがっている）
     * → 固定資産、流動資産が分かれている（比率が見たい）
     * → 資産目標額の表示
     * → 資産合計額（折れ線グラフ）
     * 資産入力がない月はどうする（固定資産だけ表示？ 0と表示？）
     * 
     */
    public function fetchAssetTrendData()
    {
        return;
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
