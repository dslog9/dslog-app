<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPanelContentBlock extends Model
{
    protected $fillable = [
        'test_panel_id',
        'type',
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

    public function items()
    {
        return $this->hasMany(TestPanelContentBlockItem::class)
            ->orderBy('sort_order');
    }
}