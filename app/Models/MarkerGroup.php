<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkerGroup extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'seo_title',
        'seo_description',
        'description'
    ];

    public function markers()
    {
        return $this->hasMany(Marker::class, 'group_id');
    }
}