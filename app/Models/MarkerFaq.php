<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerFaq extends Model
{
    protected $fillable = [
        'marker_id',
        'question',
        'answer',
        'sort_order'
    ];

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }
}