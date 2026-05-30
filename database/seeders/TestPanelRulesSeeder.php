<?php

namespace Database\Seeders;

use App\Models\TestPanel;
use Illuminate\Database\Seeder;

class TestPanelRulesSeeder extends Seeder
{
    public function run(): void
    {
        $basic = TestPanel::where('slug', 'basic-checkup')->first();

        if (!$basic) {
            return;
        }

        $rules = [
            'hemoglobin' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Базовый показатель общего анализа крови.',
            ],
            'wbc' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Помогает оценить признаки воспаления и инфекции.',
            ],
            'platelets' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Важен для оценки свёртывания крови.',
            ],
            'glucose' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Базовый показатель углеводного обмена.',
            ],
            'alt' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Один из базовых показателей печени.',
            ],
            'ast' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Оценивается вместе с АЛТ и другими печёночными показателями.',
            ],
            'creatinine' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Базовый показатель функции почек.',
            ],
            'total-cholesterol' => [
                'age_min' => 30,
                'age_max' => null,
                'gender' => null,
                'is_required' => true,
                'reason' => 'Помогает оценить липидный обмен и сердечно-сосудистые риски.',
            ],
            'tsh' => [
                'age_min' => 35,
                'age_max' => null,
                'gender' => null,
                'is_required' => false,
                'reason' => 'Полезен для скрининга функции щитовидной железы, особенно при жалобах.',
            ],
            'ferritin' => [
                'age_min' => null,
                'age_max' => null,
                'gender' => 'female',
                'is_required' => false,
                'reason' => 'Помогает оценить запасы железа, особенно у женщин.',
            ],
        ];

        foreach ($rules as $markerSlug => $data) {
            $basic->markers()
                ->whereHas('marker', fn ($q) => $q->where('slug', $markerSlug))
                ->update($data);
        }
    }
}