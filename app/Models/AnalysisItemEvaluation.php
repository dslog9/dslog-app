<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalysisItemEvaluation extends Model
{
    protected $fillable = [
        'analysis_item_id',
        'marker_id',
        'marker_scoring_profile_id',
        'marker_scoring_rule_id',
        'status',
        'direction',
        'value',
        'unit',
        'applied_thresholds',
        'explanation',
    ];

    protected $casts = [
        'value' => 'float',
        'applied_thresholds' => 'array',
        'explanation' => 'array',
    ];

    public function analysisItem()
    {
        return $this->belongsTo(AnalysisItem::class);
    }

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }

    public function scoringProfile()
    {
        return $this->belongsTo(MarkerScoringProfile::class, 'marker_scoring_profile_id');
    }

    public function scoringRule()
    {
        return $this->belongsTo(MarkerScoringRule::class, 'marker_scoring_rule_id');
    }
}