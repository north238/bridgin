<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenreRisk extends Model
{
    use HasFactory;

    protected $table = 'genres_risks';

    protected $guarded = [
        'id',
        'risk_id',
        'genre_id'
    ];

    public function risks(): BelongsTo
    {
        return $this->belongsTo(Risk::class);
    }
    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
