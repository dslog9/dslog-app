<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPanelFaq extends Model
{
    protected $fillable = [
        'test_panel_id',
        'question',
        'answer',
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
}