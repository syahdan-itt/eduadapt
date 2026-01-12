<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVersions extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialVersionsFactory> */
    use HasFactory;

    protected $fillable = [
        'material_id',
        'version_type',
        'content',
    ];

    public function material()
    {
        return $this->belongsTo(Materials::class, 'material_id');
    }
}
