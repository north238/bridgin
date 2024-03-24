<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Asset extends Model
{
    use HasFactory;
    use Sortable;
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
        'updated_at'
    ];

    /**
     * カテゴリテーブルとJoinしたものを全件取得
     * 日時の指定（いつから、いつまで）
     * 
     * @param $userID, $betweenMonthArray
     * @return query $result 
     */
    public function assetsQuery($userId, $betweenMonthArray, $sortData) 
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
     * 
     * @param $userId
     * @return string $result
     */
    public function minAsset($userId) 
    {
        $result = Asset::query()
            ->where('user_id', $userId)
            ->min('registration_date');

        return $result;
    }
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
