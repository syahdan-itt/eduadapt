<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiRecommendations extends Model
{
    /** @use HasFactory<\Database\Factories\AiRecommendationsFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'material_id',
        'recommended_version',
        'next_difficulty',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function material()
    {
        return $this->belongsTo(Materials::class, 'material_id');
    }
}
