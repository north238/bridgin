<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'name',
        'genre_id'
    ];

    /**
     * カテゴリデータを取得する
     */
    public function getCategoriesData()
    {
        $result = Category::query()
            ->with(['genre:id,name']);
        return $result;
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
