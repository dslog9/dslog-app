<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalysisItem extends Model
{

    protected $fillable = [
        'analysis_id',
        'marker_id',
        'marker_code',
        'marker_name',
        'marker_label',
        'value',
        'value_text',
        'unit',
        'reference_range',
        'status',
        'sort_order',
    ];

    public function analysis()
    {
        return $this->belongsTo(Analysis::class);
    }

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }

    public function evaluations()
    {
        return $this->hasMany(AnalysisItemEvaluation::class);
    }

    public function latestEvaluation()
    {
        return $this->hasOne(AnalysisItemEvaluation::class)->latestOfMany();
    }

}