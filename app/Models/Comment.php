<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    /**
     * ユーザーが何かつぶやきたいときに使用
     *
     * @var array<string>
     */
    protected $fillable = [
        'comment',
    ];

    public function userComments(): HasMany
    {
        return $this->hasMany(UserComment::class);
    }
}
