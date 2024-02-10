<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'name',
    ];

    public function genresRisks(): BelongsToMany
    {
        return $this->belongsToMany(GenreRisk::class, 'genres_risks');
    }
}
