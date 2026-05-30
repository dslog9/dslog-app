<?php

namespace Database\Seeders;

use App\Models\Marker;
use App\Models\TestPanel;
use App\Models\TestPanelMarker;
use Illuminate\Database\Seeder;

class BasicCheckupPanelSeeder extends Seeder
{
    public function run(): void
    {
        $panel = TestPanel::updateOrCreate(
            ['slug' => 'basic-checkup'],
            [
                'name' => 'Базовый чек-ап',
                'seo_title' => 'Базовый чек-ап: какие анализы сдать',
                'seo_description' => 'Базовый набор анализов для общей оценки состояния организма.',
                'description' => 'Стартовый набор показателей для регулярного контроля здоровья.',
            ]
        );

        $items = [
            ['slug' => 'hemoglobin', 'priority' => 10, 'frequency_months' => 12, 'note' => 'Оценка риска анемии и общего состояния крови.'],
            ['slug' => 'wbc', 'priority' => 20, 'frequency_months' => 12, 'note' => 'Оценка воспаления и иммунной реакции.'],
            ['slug' => 'platelets', 'priority' => 30, 'frequency_months' => 12, 'note' => 'Оценка свёртывания и общего анализа крови.'],
            ['slug' => 'glucose', 'priority' => 40, 'frequency_months' => 12, 'note' => 'Оценка углеводного обмена.'],
            ['slug' => 'alt', 'priority' => 50, 'frequency_months' => 12, 'note' => 'Оценка состояния печени.'],
            ['slug' => 'ast', 'priority' => 60, 'frequency_months' => 12, 'note' => 'Оценка печени, мышц и общего биохимического профиля.'],
            ['slug' => 'creatinine', 'priority' => 70, 'frequency_months' => 12, 'note' => 'Оценка функции почек.'],
            ['slug' => 'total-cholesterol', 'priority' => 80, 'frequency_months' => 12, 'note' => 'Первичная оценка липидного обмена.'],
            ['slug' => 'tsh', 'priority' => 90, 'frequency_months' => 12, 'note' => 'Скрининг функции щитовидной железы.'],
            ['slug' => 'ferritin', 'priority' => 100, 'frequency_months' => 12, 'note' => 'Оценка запасов железа.'],
        ];

        foreach ($items as $item) {
            $marker = Marker::where('slug', $item['slug'])->first();

            if (! $marker) {
                $this->command?->warn("Marker not found: {$item['slug']}");
                continue;
            }

            TestPanelMarker::updateOrCreate(
                [
                    'test_panel_id' => $panel->id,
                    'marker_id' => $marker->id,
                ],
                [
                    'priority' => $item['priority'],
                    'frequency_months' => $item['frequency_months'],
                    'note' => $item['note'],
                ]
            );
        }
    }
}