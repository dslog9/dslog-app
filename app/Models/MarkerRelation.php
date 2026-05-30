<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerRelation extends Model
{
    protected $fillable = [
        'marker_id',
        'related_marker_id',
        'relation_type',
        'priority',
        'note'
    ];

    public function marker()
    {
        return $this->belongsTo(Marker::class, 'marker_id');
    }

    public function relatedMarker()
    {
        return $this->belongsTo(Marker::class, 'related_marker_id');
    }
}