<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\MarkerScoringRule;
use App\Models\TestPanel;
use App\Models\TestPanelMarker;

class Marker extends Model
{
    protected $fillable = [
        'code',
        'slug',
        'name',
        'title',
        'h1',
        'group_id',
        'description',
        'seo_title',
        'seo_description',
        'seo_intro',
        'short',
        'what_is',
        'risks',
        'what_to_do',
        'when_to_test',
        'preparation',
        'unit',
        'is_active',
        'norms',
        'low',
        'high',
        'interpretation',
        'what_to_do',
        'when_to_test',
        'page_blocks',
    ];



    public function faqs()
    {
        return $this->hasMany(MarkerFaq::class);
    }



    public function group()
    {
        return $this->belongsTo(MarkerGroup::class, 'group_id');
    }
    
    public function relations()
    {
        return $this->hasMany(MarkerRelation::class, 'marker_id')
            ->orderBy('priority');
    }

    public function relatedMarkers()
    {
        return $this->belongsToMany(
            Marker::class,
            'marker_relations',
            'marker_id',
            'related_marker_id'
        );
    }

    public function ranges()
    {
        return $this->hasMany(MarkerRange::class);
    }

    public function synonyms()
    {
        return $this->hasMany(MarkerSynonym::class);
    }

/*   
    protected $casts = [
        'norms' => 'array',
        'low' => 'array',
        'high' => 'array',
        'interpretation' => 'array',
        'what_to_do' => 'array',
        'page_blocks' => 'array',
        'risks' => 'array',
        'when_to_test' => 'array',
        'preparation' => 'array',
        'is_active' => 'boolean',
    ];
*/

    public function testPanelMarkers()
    {
        return $this->hasMany(TestPanelMarker::class);
    }

    public function testPanels()
    {
        return $this->belongsToMany(
            TestPanel::class,
            'test_panel_markers',
            'marker_id',
            'test_panel_id'
        )->withPivot([
            'priority',
            'note',
            'frequency_months',
            'age_min',
            'age_max',
            'gender',
            'is_required',
            'reason',
            'test_panel_section_id',
            'role',
        ]);
    }

    protected function norms(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function low(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function high(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function interpretation(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function whatToDo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function risks(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function whenToTest(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function preparation(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    protected function pageBlocks(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->decodeJsonField($value),
        );
    }

    private function decodeJsonField($value): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE) {

            if (is_string($decoded)) {
                $decodedAgain = json_decode($decoded, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedAgain)) {
                    return $decodedAgain;
                }
            }

            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    public function referenceRanges()
    {
        return $this->hasMany(MarkerReferenceRange::class);
    }
    
    public function scoringRules()
    {
        return $this->hasMany(MarkerScoringRule::class);
    }

    public function analysisItems()
    {
        return $this->hasMany(AnalysisItem::class);
    }

    public function profileApplicabilities()
    {
        return $this->hasMany(
            MarkerProfileApplicability::class
        );
    }
}

