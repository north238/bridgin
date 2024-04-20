<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetSwitchStatus extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'user_id',
        'debut_status',
        'asset_type_status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
