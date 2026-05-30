<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerProfileApplicability extends Model
{
    protected $table = 'marker_profile_applicability';

    protected $fillable = [
        'marker_id',
        'scoring_profile_id',

        'is_primary',
        'priority',

        'reason',
        'note',

        'is_active',
        'applicability_status',
    ];

/*
|--------------------------------------------------------------------------
| applicability_status
|--------------------------------------------------------------------------
|
| applicable
| not_applicable
| needs_review
|
*/

    protected $casts = [
        'is_primary' => 'boolean',
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

