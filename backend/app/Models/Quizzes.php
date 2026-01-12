<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizzes extends Model
{
    /** @use HasFactory<\Database\Factories\QuizzesFactory> */
    use HasFactory;

    protected $fillable = [
        'material_id',
        'question',
        'difficulty',
    ];

    public function material()
    {
        return $this->belongsTo(Materials::class, 'material_id');
    }

    public function options()
    {
        return $this->hasMany(QuizOptions::class, 'quiz_id');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempts::class, 'quiz_id');
    }
}
