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

    /**
     * ジャンルIDを取得する
     */
    public function getGenreId($categoryId)
    {
        $result = Category::query()
            ->where('id', $categoryId)
            ->pluck('genre_id')
            ->first();

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

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class);
    }
}
