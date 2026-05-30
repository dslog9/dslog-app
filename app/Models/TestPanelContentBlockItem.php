<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPanelContentBlockItem extends Model
{
    protected $fillable = [
        'test_panel_content_block_id',
        'title',
        'description',
        'sort_order',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function block()
    {
        return $this->belongsTo(
            TestPanelContentBlock::class,
            'test_panel_content_block_id'
        );
    }
}