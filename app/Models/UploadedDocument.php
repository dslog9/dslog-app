<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
{
    protected $fillable = [
        'user_id',
        'document_type',
        'source_type',
        'original_filename',
        'file_path',
        'mime_type',
        'file_size',
        'extracted_text',
        'detected_items_count',
        'classification_confidence',
        'classification_reason',
        'metadata',
    ];

    protected $casts = [
        'detected_items_count' => 'integer',
        'file_size' => 'integer',
        'metadata' => 'array',
    ];

    public function analysis()
    {
        return $this->hasOne(Analysis::class);
    }
}