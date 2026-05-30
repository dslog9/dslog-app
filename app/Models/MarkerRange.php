<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerRange extends Model
{
    protected $fillable = [
        'marker_id',
        'gender',
        'age_min',
        'age_max',
        'min_value',
        'max_value',
        'unit',
        'status_type',
        'note',
        'source',
    ];

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }
}