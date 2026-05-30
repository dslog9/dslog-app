<?php

namespace Database\Seeders;

use App\Models\Marker;
use App\Models\TestPanel;
use App\Models\TestPanelMarker;
use App\Models\UserChecklist;
use App\Models\UserChecklistItem;
use Illuminate\Database\Seeder;

class DemoUserPlanSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $demoPanels = [
            [
                'slug' => 'demo-basic-checkup',
                'name' => 'Базовый чек-ап',
                'description' => 'Основные показатели для регулярного контроля здоровья.',
                'markers' => [
                    ['slug' => 'hemoglobin', 'status' => 'needs_control', 'months' => 6, 'tested' => '-20 days', 'next' => '+5 months', 'note' => 'Гемоглобин ниже оптимального уровня, стоит смотреть вместе с ферритином.'],
                    ['slug' => 'wbc', 'status' => 'overdue', 'months' => 12, 'tested' => '-14 months', 'next' => '-2 months', 'note' => 'Пора повторить общий анализ крови.'],
                    ['slug' => 'platelets', 'status' => 'not_done', 'months' => 12, 'tested' => null, 'next' => '+20 days', 'note' => 'Показатель ещё не был загружен.'],
                    ['slug' => 'glucose', 'status' => 'done', 'months' => 12, 'tested' => '-1 month', 'next' => '+11 months', 'note' => 'Последний результат без отклонений.'],
                    ['slug' => 'creatinine', 'status' => 'not_done', 'months' => 12, 'tested' => null, 'next' => '+2 months', 'note' => 'Нужен для оценки функции почек.'],
                ],
            ],
            [
                'slug' => 'demo-thyroid',
                'name' => 'Щитовидная железа',
                'description' => 'Контроль ТТГ и связанных гормонов щитовидной железы.',
                'markers' => [
                    ['slug' => 'tsh', 'status' => 'overdue', 'months' => 6, 'tested' => '-8 months', 'next' => '-1 month', 'note' => 'ТТГ пора проверить повторно.'],
                    ['slug' => 'free-t4', 'status' => 'done', 'months' => 12, 'tested' => '-3 months', 'next' => '+9 months', 'note' => 'Свободный Т4 был в пределах референса.'],
                    ['slug' => 'free-t3', 'status' => 'not_done', 'months' => 12, 'tested' => null, 'next' => '+3 months', 'note' => 'Можно проверить вместе с ТТГ при жалобах.'],
                ],
            ],
            [
                'slug' => 'demo-iron-anemia',
                'name' => 'Железо и анемия',
                'description' => 'Показатели, которые помогают оценить запасы железа и риск анемии.',
                'markers' => [
                    ['slug' => 'ferritin', 'status' => 'urgent', 'months' => 3, 'tested' => '-10 days', 'next' => '+2 months', 'note' => 'Ферритин выраженно снижен, показатель требует внимания.'],
                    ['slug' => 'serum-iron', 'status' => 'needs_control', 'months' => 6, 'tested' => '-10 days', 'next' => '+5 months', 'note' => 'Железо лучше оценивать вместе с ферритином и ОАК.'],
                    ['slug' => 'vitamin-b12', 'status' => 'done', 'months' => 12, 'tested' => '-2 months', 'next' => '+10 months', 'note' => 'Последний результат без отклонений.'],
                    ['slug' => 'folate', 'status' => 'not_done', 'months' => 12, 'tested' => null, 'next' => '+1 month', 'note' => 'Можно проверить при признаках анемии или усталости.'],
                ],
            ],
            [
                'slug' => 'demo-heart-metabolism',
                'name' => 'Липиды и обмен',
                'description' => 'Контроль сахара, холестерина и метаболических рисков.',
                'markers' => [
                    ['slug' => 'total-cholesterol', 'status' => 'needs_control', 'months' => 6, 'tested' => '-1 month', 'next' => '+5 months', 'note' => 'Холестерин выше желаемого уровня, стоит смотреть липидный профиль целиком.'],
                    ['slug' => 'ldl', 'status' => 'needs_control', 'months' => 6, 'tested' => '-1 month', 'next' => '+5 months', 'note' => 'ЛПНП требует контроля в динамике.'],
                    ['slug' => 'hdl', 'status' => 'done', 'months' => 12, 'tested' => '-1 month', 'next' => '+11 months', 'note' => 'Показатель без явных отклонений.'],
                    ['slug' => 'triglycerides', 'status' => 'done', 'months' => 12, 'tested' => '-1 month', 'next' => '+11 months', 'note' => 'Последний результат в норме.'],
                ],
            ],
        ];

        UserChecklist::where('user_id', $userId)
            ->whereHas('testPanel', fn ($query) => $query->where('slug', 'like', 'demo-%'))
            ->get()
            ->each(function (UserChecklist $checklist) {
                $checklist->items()->delete();
                $checklist->delete();
            });

        foreach ($demoPanels as $panelData) {
            $panel = TestPanel::updateOrCreate(
                ['slug' => $panelData['slug']],
                [
                    'name' => $panelData['name'],
                    'seo_title' => $panelData['name'],
                    'seo_description' => $panelData['description'],
                    'description' => $panelData['description'],
                ]
            );

            $panel->markers()->delete();

            $checklist = UserChecklist::create([
                'user_id' => $userId,
                'test_panel_id' => $panel->id,
                'checklist_id' => null,
                'status' => 'active',
                'assigned_at' => now(),
                'notes' => 'Demo data for /my-checklist visual QA.',
            ]);

            foreach ($panelData['markers'] as $index => $markerData) {
                $marker = Marker::where('slug', $markerData['slug'])->first();

                if (!$marker) {
                    $this->command?->warn("Marker not found: {$markerData['slug']}");
                    continue;
                }

                TestPanelMarker::create([
                    'test_panel_id' => $panel->id,
                    'marker_id' => $marker->id,
                    'priority' => ($index + 1) * 10,
                    'note' => $markerData['note'],
                    'frequency_months' => $markerData['months'],
                ]);

                UserChecklistItem::create([
                    'user_checklist_id' => $checklist->id,
                    'marker_id' => $marker->id,
                    'frequency_months' => $markerData['months'],
                    'last_tested_at' => $markerData['tested'] ? now()->modify($markerData['tested']) : null,
                    'next_due_at' => $markerData['next'] ? now()->modify($markerData['next']) : null,
                    'status' => $markerData['status'],
                    'last_analysis_item_id' => null,
                    'note' => $markerData['note'],
                ]);
            }
        }
    }
}