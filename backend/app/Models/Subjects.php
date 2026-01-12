<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectsFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function materials()
    {
        return $this->hasMany(Materials::class, 'subject_id');
    }
}
