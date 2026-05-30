<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPanelMarker extends Model
{
    protected $fillable = [
        'test_panel_id',
        'test_panel_section_id',
        'marker_id',
        'priority',
        'note',
        'frequency_months',

        'age_min',
        'age_max',
        'gender',
        'is_required',
        'reason',
        'role',

    ];


    protected $casts = [
        'is_required' => 'boolean',
        'age_min' => 'integer',
        'age_max' => 'integer',
        'frequency_months' => 'integer',
    ];

    public function panel()
    {
        return $this->belongsTo(TestPanel::class, 'test_panel_id');
    }

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }


    public function section()
    {
        return $this->belongsTo(TestPanelSection::class, 'test_panel_section_id');
    }




}