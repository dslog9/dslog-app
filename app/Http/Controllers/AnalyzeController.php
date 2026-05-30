<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\AnalysisItem;
use App\Models\UserChecklist;
use App\Models\UserProfile;
use App\Services\AiService;
use App\Services\AnalysisItemEvaluationService;
use App\Services\AnalysisItemStatusService;
use App\Services\ChecklistProgressService;
use App\Services\MarkerMappingService;
use App\Services\OcrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\DocumentClassificationService;
use App\Models\UploadedDocument;

class AnalyzeController extends Controller
{
    public function analyze(Request $request, AiService $ai)
    {
        $startedAt = microtime(true);

        $inputMode = $request->input('input_type'); // text / file
        $text = '';
        $inputType = 'text';
        $filePath = null;

        if (!$inputMode) {
            $inputMode = $request->hasFile('file') ? 'file' : 'text';
        }

        if ($inputMode === 'text') {
            $text = trim((string) $request->input('text', ''));
            $inputType = 'text';
        } elseif ($inputMode === 'file') {
            if (!$request->hasFile('file')) {
                return response()->json([
                    'status' => 'error',
                    'error' => ['message' => 'Файл не передан'],
                ], 422);
            }

            $file = $request->file('file');
            $mimeType = $file->getMimeType();

            if ($mimeType === 'application/pdf') {
                $inputType = 'pdf';
            } elseif (str_starts_with($mimeType, 'image/')) {
                $inputType = 'image';
            } else {
                return response()->json([
                    'status' => 'error',
                    'error' => ['message' => 'Неподдерживаемый тип файла'],
                ], 422);
            }

            $path = $file->store('uploads');
            $filePath = $path;

            $fullPath = storage_path('app/private/' . $path);

            try {
                $ocrService = new OcrService();
                $text = trim($ocrService->extractText($fullPath));
            } catch (\Throwable $e) {
                return response()->json([
                    'status' => 'error',
                    'error' => ['message' => 'Ошибка OCR'],
                ], 500);
            }
        }

        if ($text === '') {
            return response()->json([
                'status' => 'error',
                'error' => ['message' => 'Пустой ввод'],
            ], 422);
        }

        $analysisData = $ai->analyze($text);

        $parsedItems = app(\App\Services\TextLabParserService::class)
            ->parse($text);

        $items = !empty($parsedItems)
            ? $parsedItems
            : ($items ?? []);

        $classification = app(DocumentClassificationService::class)
            ->classify($text, $items);

        $detectedItemsCount = count($items);

        $documentType = $classification['document_type'];
        $classificationReason = $classification['reason'] ?? null;       

        $userId = 1; // позже auth()->id()

        $uploadedDocument = UploadedDocument::create([
            'user_id' => $userId,

            'document_type' => $documentType,
            'source_type' => $inputType,

            'original_filename' => isset($file)
                ? $file->getClientOriginalName()
                : null,

            'file_path' => $filePath,

            'mime_type' => isset($mimeType)
                ? $mimeType
                : null,

            'file_size' => isset($file)
                ? $file->getSize()
                : null,

            'extracted_text' => $text,

            'detected_items_count' => $detectedItemsCount,

            'classification_confidence' => $classification['confidence'] ?? null,

            'classification_reason' => $classificationReason,

            'metadata' => [
                'input_mode' => $inputMode,
            ],
        ]);

        $analysisId = null;

        if ($documentType === 'lab_analysis') {

            $analysisId = DB::table('analyses')->insertGetId([
                'user_id' => $userId,

                'uploaded_document_id' => $uploadedDocument->id,

                'source_type' => $inputType,

                'document_type' => $documentType,

                'detected_items_count' => $detectedItemsCount,

                'classification_reason' => $classificationReason,

                'file_path' => $filePath,

                'extracted_text' => $text,

                'summary' => $analysisData['summary'] ?? null,

                'details' => $analysisData['details'] ?? null,

                'risks' => json_encode(
                    $analysisData['risks'] ?? [],
                    JSON_UNESCAPED_UNICODE
                ),

                'recommendations' => json_encode(
                    $analysisData['recommendations'] ?? [],
                    JSON_UNESCAPED_UNICODE
                ),

                'raw_ai_response' => json_encode(
                    $analysisData,
                    JSON_UNESCAPED_UNICODE
                ),

                'analyzed_at' => now(),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($documentType === 'lab_analysis' && $analysisId) {

            foreach (($items ?? []) as $index => $item) {

                AnalysisItem::create([
                    'analysis_id' => $analysisId,
                    'marker_code' => $item['marker_code'] ?? null,
                    'marker_name' => $item['marker_name'] ?? null,
                    'marker_label' => $item['marker_label'] ?? null,
                    'value' => $item['value'] ?? null,
                    'value_text' => $item['value_text'] ?? null,
                    'unit' => $item['unit'] ?? null,
                    'reference_range' => $item['reference_range'] ?? null,
                    'status' => $item['status'] ?? null,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        $userId = 1; // временно, пока нет auth

        if ($documentType === 'lab_analysis') {

            app(MarkerMappingService::class)
                ->mapAnalysisItems($analysisId);

            $profile = UserProfile::where('user_id', $userId)->first();

            app(AnalysisItemStatusService::class)
                ->updateAnalysisItems($analysisId, $profile);

            app(AnalysisItemEvaluationService::class)
                ->evaluateAnalysisItems($analysisId);
        }

        $analysisModel = $analysisId
            ? Analysis::find($analysisId)
            : null;

        if ($analysisModel && $documentType === 'lab_analysis') {
            $userChecklists = UserChecklist::query()
                ->where('user_id', $userId)
                ->whereNotNull('test_panel_id')
                ->get();

            foreach ($userChecklists as $userChecklist) {
                app(ChecklistProgressService::class)
                    ->applyAnalysis($userChecklist, $analysisModel);

                app(ChecklistProgressService::class)
                    ->refreshOverdue($userChecklist);
            }
        }

        $checklistId = 2; // legacy временно

        $resultStatus = 'ok';

        if (str_contains(mb_strtolower($analysisData['summary'] ?? ''), 'отклон')) {
            $resultStatus = 'warning';
        }

        DB::table('user_checklists')
            ->where('user_id', $userId)
            ->where('checklist_id', $checklistId)
            ->update([
                'status' => 'completed',
                'result_status' => $resultStatus,
                'last_analysis_id' => $analysisId,
                'completed_at' => now(),
                'due_at' => now()->addMonths(3),
                'updated_at' => now(),
            ]);

        $processingTimeMs = (int) round((microtime(true) - $startedAt) * 1000);

        return response()->json([
            'status' => 'success',
            'data' => [
                'analysis_id' => $analysisId,
                'input' => [
                    'type' => $inputType,
                    'mode' => $inputMode,
                ],
                'extracted_text' => $text,
                'analysis' => $analysisData,
                'document_type' => $documentType,
                'detected_items_count' => $detectedItemsCount,
                'uploaded_document_id' => $uploadedDocument->id,

            ],
            'meta' => [
                'processing_time_ms' => $processingTimeMs,
            ],
        ]);
    }

    public function show(int $id)
    {
        $analysis = DB::table('analyses')->where('id', $id)->first();

        if (!$analysis) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $items = DB::table('analysis_items')
            ->where('analysis_id', $id)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'analysis' => $analysis,
            'items' => $items,
        ]);
    }
}