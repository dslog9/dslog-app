<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestPanelSection;

class TestPanel extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'seo_title',
        'seo_description',
        'description',
        'category',
        'panel_type',
        'thematic_type',
        'gender',
        'age_min',
        'age_max',
        'short_description',
        'sort_order',
        'is_active',
        'cover_image',
    ];


    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(TestPanelSection::class)->orderBy('priority');
    }

    public function panelMarkers()
    {
        return $this->hasMany(TestPanelMarker::class)->orderBy('priority');
    }


    public function markers()
    {
        return $this->belongsToMany(Marker::class, 'test_panel_markers')
            ->withPivot([
                'test_panel_section_id',
                'priority',
                'frequency_months',
                'age_min',
                'age_max',
                'gender',
                'is_required',
                'reason',
                'note',
            ])
            ->orderBy('test_panel_markers.priority');
    }

    public function contentBlocks()
    {
        return $this->hasMany(TestPanelContentBlock::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function relatedPanels()
    {
        return $this->hasMany(TestPanelRelatedPanel::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function faqs()
    {
        return $this->hasMany(TestPanelFaq::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}