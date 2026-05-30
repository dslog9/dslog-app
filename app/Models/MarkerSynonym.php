<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerSynonym extends Model
{
    protected $fillable = [
        'marker_id',
        'name',
    ];

    public function marker()
    {
        return $this->belongsTo(Marker::class);
    }
}