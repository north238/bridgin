<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'name',
        'risk_rank'
    ];

    /**
     * ジャンルデータの取得
     */
    public function getGenreData()
    {
        $result = Genre::query();
        return $result;
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class);
    }
}
