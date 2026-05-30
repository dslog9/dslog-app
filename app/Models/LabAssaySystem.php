<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabAssaySystem extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'lab_name',
        'method',
        'analyzer',
        'reagent',
        'specimen_type',
        'unit',
        'source',
        'note',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];
}