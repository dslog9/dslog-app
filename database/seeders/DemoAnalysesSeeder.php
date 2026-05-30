<?php

namespace Database\Seeders;

use App\Models\Analysis;
use App\Models\AnalysisItem;
use App\Models\Marker;
use App\Models\UserChecklist;
use App\Models\UserChecklistItem;
use Illuminate\Database\Seeder;

class DemoAnalysesSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $demoAnalyses = [
            [
                'date' => '-10 days',
                'summary' => 'Загружен общий анализ крови и показатели железа. Есть признаки дефицита железа и сниженного гемоглобина.',
                'details' => 'Демо-анализ для визуальной отладки DSlog: гемоглобин и ферритин требуют внимания.',
                'items' => [
                    ['slug' => 'hemoglobin', 'value' => 112, 'unit' => 'г/л', 'reference' => '120–150', 'status' => 'low'],
                    ['slug' => 'ferritin', 'value' => 8, 'unit' => 'нг/мл', 'reference' => '30–150', 'status' => 'critical_low'],
                    ['slug' => 'serum-iron', 'value' => 7.5, 'unit' => 'мкмоль/л', 'reference' => '9–30', 'status' => 'low'],
                    ['slug' => 'wbc', 'value' => 5.6, 'unit' => '10^9/л', 'reference' => '4.0–9.0', 'status' => 'normal'],
                    ['slug' => 'platelets', 'value' => 255, 'unit' => '10^9/л', 'reference' => '150–400', 'status' => 'normal'],
                ],
            ],
            [
                'date' => '-1 month',
                'summary' => 'Проверен липидный профиль и глюкоза. Холестерин и ЛПНП требуют контроля.',
                'details' => 'Демо-анализ для блока истории и карточек метаболических рисков.',
                'items' => [
                    ['slug' => 'glucose', 'value' => 5.1, 'unit' => 'ммоль/л', 'reference' => '3.9–5.5', 'status' => 'normal'],
                    ['slug' => 'total-cholesterol', 'value' => 6.2, 'unit' => 'ммоль/л', 'reference' => '<5.2', 'status' => 'high'],
                    ['slug' => 'ldl', 'value' => 4.1, 'unit' => 'ммоль/л', 'reference' => '<3.0', 'status' => 'high'],
                    ['slug' => 'hdl', 'value' => 1.4, 'unit' => 'ммоль/л', 'reference' => '>1.2', 'status' => 'normal'],
                    ['slug' => 'triglycerides', 'value' => 1.2, 'unit' => 'ммоль/л', 'reference' => '<1.7', 'status' => 'normal'],
                ],
            ],
            [
                'date' => '-3 months',
                'summary' => 'Проверены гормоны щитовидной железы. Свободный Т4 без отклонений, ТТГ нужно повторить в динамике.',
                'details' => 'Демо-анализ для щитовидного плана.',
                'items' => [
                    ['slug' => 'tsh', 'value' => 4.9, 'unit' => 'мМЕ/л', 'reference' => '0.4–4.0', 'status' => 'high'],
                    ['slug' => 'free-t4', 'value' => 14.2, 'unit' => 'пмоль/л', 'reference' => '10–22', 'status' => 'normal'],
                    ['slug' => 'free-t3', 'value' => 4.1, 'unit' => 'пмоль/л', 'reference' => '3.1–6.8', 'status' => 'normal'],
                ],
            ],
            [
                'date' => '-6 months',
                'summary' => 'Проверены печёночные ферменты и креатинин. Значимых отклонений по этим показателям нет.',
                'details' => 'Демо-анализ для истории нормальных показателей.',
                'items' => [
                    ['slug' => 'alt', 'value' => 24, 'unit' => 'Ед/л', 'reference' => '<35', 'status' => 'normal'],
                    ['slug' => 'ast', 'value' => 22, 'unit' => 'Ед/л', 'reference' => '<35', 'status' => 'normal'],
                    ['slug' => 'creatinine', 'value' => 71, 'unit' => 'мкмоль/л', 'reference' => '45–84', 'status' => 'normal'],
                ],
            ],
        ];

        // Удаляем только demo-анализы, чтобы повторный запуск не плодил дубли.
        Analysis::where('user_id', $userId)
            ->where('details', 'like', 'Демо-анализ%')
            ->get()
            ->each(function (Analysis $analysis) {
                $analysis->items()->delete();
                $analysis->delete();
            });

        foreach ($demoAnalyses as $analysisData) {
            $createdAt = now()->modify($analysisData['date']);

            $analysis = Analysis::create([
                'user_id' => $userId,
                'source_type' => 'text',
                'file_path' => null,
                'extracted_text' => $analysisData['summary'],
                'summary' => $analysisData['summary'],
                'details' => $analysisData['details'],
                'risks' => [],
                'recommendations' => [],
                'raw_ai_response' => [
                    'demo' => true,
                    'items' => $analysisData['items'],
                ],
                'analyzed_at' => $createdAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            foreach ($analysisData['items'] as $index => $itemData) {
                $marker = Marker::where('slug', $itemData['slug'])->first();

                if (!$marker) {
                    $this->command?->warn("Marker not found: {$itemData['slug']}");
                    continue;
                }

                $analysisItem = AnalysisItem::create([
                    'analysis_id' => $analysis->id,
                    'marker_id' => $marker->id,
                    'marker_code' => $marker->code ?? $marker->slug,
                    'marker_name' => $marker->name,
                    'marker_label' => $marker->name,
                    'value' => $itemData['value'],
                    'value_text' => (string) $itemData['value'],
                    'unit' => $itemData['unit'],
                    'reference_range' => $itemData['reference'],
                    'status' => $itemData['status'],
                    'sort_order' => ($index + 1) * 10,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $this->syncChecklistItem($userId, $marker->id, $analysisItem, $createdAt);
            }
        }

        $this->syncChecklistLastAnalysis($userId);
    }

    private function syncChecklistItem(int $userId, int $markerId, AnalysisItem $analysisItem, $testedAt): void
    {
        $status = match ($analysisItem->status) {
            'critical_low', 'critical_high' => 'urgent',
            'low', 'high', 'borderline_low', 'borderline_high' => 'needs_control',
            'normal' => 'done',
            default => 'not_done',
        };

        $items = UserChecklistItem::whereHas('checklist', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('marker_id', $markerId)
            ->get();

        foreach ($items as $item) {
            $nextDueAt = $item->frequency_months
                ? $testedAt->copy()->addMonths($item->frequency_months)
                : $item->next_due_at;

            $item->update([
                'status' => $status,
                'last_tested_at' => $testedAt,
                'next_due_at' => $nextDueAt,
                'last_analysis_item_id' => $analysisItem->id,
            ]);
        }
    }

    private function syncChecklistLastAnalysis(int $userId): void
    {
        $latestAnalysis = Analysis::where('user_id', $userId)->latest()->first();

        if (!$latestAnalysis) {
            return;
        }

        UserChecklist::where('user_id', $userId)
            ->whereNotNull('test_panel_id')
            ->update([
                'last_analysis_id' => $latestAnalysis->id,
            ]);
    }
}