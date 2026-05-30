<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerScoringRule extends Model
{
    protected $fillable = [
        'marker_id',
        'scoring_profile_id',

        'direction',
        'display_precision',
        'zone_mode',
        'health_direction',
        'critical_low_max',
        'needs_control_low_max',
        'borderline_low_max',

        'optimal_min',
        'optimal_max',

        'exceptional_min',
        'exceptional_max',

        'borderline_high_min',
        'needs_control_high_min',
        'critical_high_min',

        'unit',

        'source',
        'note',

        'is_active',
    ];

    protected $casts = [
        'critical_low_max' => 'float',
        'needs_control_low_max' => 'float',
        'borderline_low_max' => 'float',

        'optimal_min' => 'float',
        'optimal_max' => 'float',

        'exceptional_min' => 'float',
        'exceptional_max' => 'float',

        'borderline_high_min' => 'float',
        'needs_control_high_min' => 'float',
        'critical_high_min' => 'float',
        'display_precision' => 'integer',
        'is_active' => 'boolean',
    ];

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }

    public function scoringProfile()
    {
        return $this->belongsTo(
            MarkerScoringProfile::class,
            'scoring_profile_id'
        );
    }
}