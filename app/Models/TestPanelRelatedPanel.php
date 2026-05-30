<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPanelRelatedPanel extends Model
{
    protected $fillable = [
        'test_panel_id',
        'related_test_panel_id',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function panel()
    {
        return $this->belongsTo(TestPanel::class, 'test_panel_id');
    }

    public function relatedPanel()
    {
        return $this->belongsTo(TestPanel::class, 'related_test_panel_id');
    }
}