<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerScoringProfile extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'profile_type',
        'gender',
        'age_min',
        'age_max',
        'pregnant',
        'risk_factors',
        'conditions',
        'description',
        'source',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'pregnant' => 'boolean',
        'risk_factors' => 'array',
        'conditions' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scoringRules()
    {
        return $this->hasMany(MarkerScoringRule::class, 'scoring_profile_id');
    }

    public function markerApplicabilities()
    {
        return $this->hasMany(
            MarkerProfileApplicability::class,
            'scoring_profile_id'
        );
    }

}