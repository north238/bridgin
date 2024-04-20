<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    /**
     * ユーザーへのお知らせ機能
     * 何かを促したいときのためのもの
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'body',
    ];
}
