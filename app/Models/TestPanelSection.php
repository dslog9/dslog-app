<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPanelSection extends Model
{
    protected $fillable = [
        'test_panel_id',
        'slug',
        'name',
        'description',
        'priority',
        'frequency_months',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function panel()
    {
        return $this->belongsTo(TestPanel::class, 'test_panel_id');
    }

    public function panelMarkers()
    {
        return $this->hasMany(TestPanelMarker::class, 'test_panel_section_id')
            ->orderBy('priority');
    }

    public function markers()
    {
        return $this->hasManyThrough(
            Marker::class,
            TestPanelMarker::class,
            'test_panel_section_id',
            'id',
            'id',
            'marker_id'
        );
    }    
}