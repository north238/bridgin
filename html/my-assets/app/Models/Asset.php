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
     * @param int $userId
     * @param array $sortData
     * @return query $result
     */
    public function getAssetsAllData($userId, $sortData)
    {
        $sortOrder = $sortData['order'];
        $sortType = $sortData['type'];
        $result = Asset::query()
            ->where('user_id', $userId)
            ->with(['category:id,name'])
            ->orderBy($sortOrder, $sortType)
            ->orderBy('name', 'ASC')
            ->get();

        return $result;
    }

    /**
     * カテゴリテーブルとJoinしたものを全件取得
     * 日時の指定（いつから、いつまで）
     * 
     * @param int $userID
     * @param Carbon $betweenMonthArray
     * @param array $sortData
     * @return query $result
     */
    public function fetchUserAssets($userId, $betweenMonthArray, $sortData)
    {
        $sortOrder = $sortData['order'];
        $sortType = $sortData['type'];
        $result = Asset::query()
            ->where('user_id', $userId)
            ->with(['category:id,name'])
            ->whereBetween('registration_date', $betweenMonthArray)
            ->orderBy($sortOrder, $sortType)
            ->get();

        return $result;
    }

    /**
     * データの最小値を取得
     * @param int $userId
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
     * @param  integer $id
     * @param  integer $userId
     * @return query   $query
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
