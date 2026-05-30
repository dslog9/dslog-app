<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChecklist extends Model
{
    protected $fillable = [
        'user_id',
        'checklist_id',
        'test_panel_id',
        'last_analysis_id',
        'status',
        'assigned_at',
        'completed_at',
        'notes',
        'due_at',
        'result_status',
        'variant',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testPanel()
    {
        return $this->belongsTo(TestPanel::class);
    }

    public function items()
    {
        return $this->hasMany(UserChecklistItem::class);
    }

    public function lastAnalysis()
    {
        return $this->belongsTo(Analysis::class, 'last_analysis_id');
    }
}