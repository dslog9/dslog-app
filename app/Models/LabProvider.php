<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabProvider extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'search_url_pattern',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function searchUrl(string $query): string
    {
        return str_replace(
            '{query}',
            urlencode($query),
            $this->search_url_pattern
        );
    }
}