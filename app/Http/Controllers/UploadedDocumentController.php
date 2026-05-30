<?php

namespace App\Http\Controllers;

use App\Models\UploadedDocument;
use Illuminate\Http\Request;

class UploadedDocumentController extends Controller
{
    public function index(Request $request)
    {
        $userId = null; // позже auth()->id()

        $type = $request->query('type', 'all');

        $documentsQuery = UploadedDocument::query()
            ->where('user_id', $userId)
            ->latest();

        if ($type === 'lab_analysis') {
            $documentsQuery->where('document_type', 'lab_analysis');
        }

        if ($type === 'other') {
            $documentsQuery->where('document_type', 'other');
        }

        $documents = $documentsQuery->paginate(30)->withQueryString();

        return view('documents.index', [
            'documents' => $documents,
            'type' => $type,
        ]);
    }

    public function show(UploadedDocument $document)
    {
        $document->load([
            'analysis.items.marker',
            'analysis.items.latestEvaluation',
        ]);

        return view('documents.show', [
            'document' => $document,
        ]);
    }
}