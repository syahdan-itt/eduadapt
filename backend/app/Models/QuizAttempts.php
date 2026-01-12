<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempts extends Model
{
    /** @use HasFactory<\Database\Factories\QuizAttemptsFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'selected_option_id',
        'is_correct',
        'time_spent',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quizzes::class, 'quiz_id');
    }

    public function selectedOption()
    {
        return $this->belongsTo(QuizOptions::class, 'selected_option_id');
    }
}
