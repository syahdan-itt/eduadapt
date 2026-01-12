<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialsFactory> */
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'content_text',
        'difficulty',
        'created_by',
    ];

    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function versions()
    {
        return $this->hasMany(MaterialVersions::class, 'material_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quizzes::class, 'material_id');
    }

    public function aiRecommendations()
    {
        return $this->hasMany(AiRecommendations::class, 'material_id');
    }
}
