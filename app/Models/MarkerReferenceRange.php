<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerReferenceRange extends Model
{
    protected $fillable = [
        'marker_id',
        'lab_assay_system_id',

        'gender',
        'age_min',
        'age_max',

        'pregnant',

        'min_value',
        'max_value',
        'unit',

        'range_type',

        'source',
        'note',

        'is_active',
    ];

    protected $casts = [
        'pregnant' => 'boolean',
        'is_active' => 'boolean',

        'min_value' => 'float',
        'max_value' => 'float',
    ];

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }

    public function assaySystem()
    {
        return $this->belongsTo(LabAssaySystem::class, 'lab_assay_system_id');
    }
}