<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $fillable = [
        'user_id',
        'source_type',
        'file_path',
        'extracted_text',
        'summary',
        'details',
        'risks',
        'recommendations',
        'raw_ai_response',
        'document_type',
        'detected_items_count',
        'classification_reason',
        'uploaded_document_id',
    ];

    protected $casts = [
        'risks' => 'array',
        'recommendations' => 'array',
        'raw_ai_response' => 'array',
        'detected_items_count' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(AnalysisItem::class);
    }

    public function uploadedDocument()
    {
        return $this->belongsTo(UploadedDocument::class);
    }

}