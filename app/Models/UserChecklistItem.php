<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChecklistItem extends Model
{
    protected $fillable = [
        'user_checklist_id',
        'marker_id',
        'frequency_months',
        'last_tested_at',
        'next_due_at',
        'status',
        'last_analysis_item_id',
        'note',
    ];

    protected $casts = [
        'last_tested_at' => 'datetime',
        'next_due_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function checklist()
    {
        return $this->belongsTo(UserChecklist::class, 'user_checklist_id');
    }

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }

    public function lastAnalysisItem()
    {
        return $this->belongsTo(AnalysisItem::class, 'last_analysis_item_id');
    }
}