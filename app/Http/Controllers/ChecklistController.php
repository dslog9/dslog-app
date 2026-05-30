<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\UploadedDocument;
use App\Models\UserChecklist;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = 1;

        $items = DB::table('user_checklists as uc')
            ->join('checklists as c', 'c.id', '=', 'uc.checklist_id')
            ->leftJoin('analyses as a', 'a.id', '=', 'uc.last_analysis_id')
            ->where('uc.user_id', $userId)
            ->select([
                'uc.id',
                'uc.user_id',
                'uc.status',
                'uc.result_status',
                'uc.due_at',
                'uc.completed_at',
                'uc.last_analysis_id',
                'c.title',
                'c.description',
                'c.category',
                'c.frequency_value',
                'c.frequency_unit',
                'a.analyzed_at',
            ])
            ->orderBy('uc.due_at')
            ->orderBy('c.title')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $items,
        ]);
    }

    public function myChecklist()
    {
        return view('checklist.index');
    }

    public function plans()
    {
        $userId = 1;

        $checklists = UserChecklist::with([
            'items.marker',
            'items.lastAnalysisItem',
            'testPanel',
        ])
            ->where('user_id', $userId)
            ->whereNotNull('test_panel_id')
            ->latest()
            ->get();

        $recentAnalyses = Analysis::query()
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereNull('user_id');
            })
            ->latest()
            ->take(10)
            ->get();

        return view('checklist.plans', [
            'checklists' => $checklists,
            'recentAnalyses' => $recentAnalyses,
        ]);
    }

    public function uploads()
    {
        $userId = 1;

        $type = request('type', 'all');

        $query = UploadedDocument::query()
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereNull('user_id');
            })
            ->latest();

        if ($type === 'lab_analysis') {
            $query->where('document_type', 'lab_analysis');
        }

        if ($type === 'other') {
            $query->where('document_type', 'other');
        }

        $uploadedDocuments = $query->paginate(30)->withQueryString();

        return view('checklist.uploads', [
            'uploadedDocuments' => $uploadedDocuments,
        ]);
    }


    public function uploadShow(UploadedDocument $document)
    {
        $document->load([
            'analysis.items.marker',
            'analysis.items.latestEvaluation',
        ]);

        return view('checklist.upload-show', [
            'document' => $document,
        ]);
    }

    public function profile()
    {
        return view('checklist.profile');
    }

    public function dynamics()
    {
        $userId = 1;

        $markers = \App\Models\Marker::query()
            ->whereHas('analysisItems.analysis', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->withCount([
                'analysisItems as user_analysis_items_count' => function ($query) use ($userId) {
                    $query->whereHas('analysis', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    });
                },
            ])
            ->orderBy('name')
            ->get();

        return view('checklist.dynamics', [
            'markers' => $markers,
        ]);
    }

    public function dynamicShow(\App\Models\Marker $marker)
    {
        $userId = 1;

        $history = app(\App\Services\MarkerHistoryService::class)
            ->getMarkerHistory($marker->id, $userId);

        $chart = app(\App\Services\MarkerChartDataService::class)
            ->build($history);

        return view('checklist.dynamic-show', [
            'marker' => $marker,
            'history' => $history,
            'chart' => $chart,
        ]);
    }

}