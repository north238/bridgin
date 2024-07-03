<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'color_code'
    ];

    public function genres(): HasMany
    {
        return $this->hasMany(Genre::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
