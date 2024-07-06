<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserComment extends Model
{
    use HasFactory;

    protected $table = 'user_comments';

    protected $guarded = [
        'user_id',
        'comment_id'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }
    public function comments(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
