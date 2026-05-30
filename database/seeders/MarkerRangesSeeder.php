<?php

namespace Database\Seeders;

use App\Models\Marker;
use App\Models\MarkerRange;
use Illuminate\Database\Seeder;

class MarkerRangesSeeder extends Seeder
{
    public function run(): void
    {
        MarkerRange::truncate();

        $this->add('hemoglobin', [
            ['male', 18, 150, 130, 170, 'г/л', 'normal', 'Взрослые мужчины'],
            ['female', 18, 150, 120, 150, 'г/л', 'normal', 'Взрослые женщины'],
        ]);

        $this->add('hematocrit', [
            ['male', 18, 150, 40, 50, '%', 'normal', 'Взрослые мужчины'],
            ['female', 18, 150, 36, 46, '%', 'normal', 'Взрослые женщины'],
        ]);

        $this->add('rbc', [
            ['male', 18, 150, 4.3, 5.7, '10^12/л', 'normal', 'Взрослые мужчины'],
            ['female', 18, 150, 3.8, 5.1, '10^12/л', 'normal', 'Взрослые женщины'],
        ]);

        $this->add('wbc', [
            [null, 18, 150, 4.0, 9.0, '10^9/л', 'normal', 'Взрослые'],
        ]);

        $this->add('platelets', [
            [null, 18, 150, 150, 400, '10^9/л', 'normal', 'Взрослые'],
        ]);

        $this->add('glucose', [
            [null, 18, 150, 3.9, 5.5, 'ммоль/л', 'normal', 'Натощак'],
        ]);

        $this->add('hba1c', [
            [null, 18, 150, 0, 5.6, '%', 'normal', 'Обычно норма'],
            [null, 18, 150, 5.7, 6.4, '%', 'borderline_high', 'Возможный предиабет'],
            [null, 18, 150, 6.5, null, '%', 'critical_high', 'Требует оценки на диабет'],
        ]);

        $this->add('creatinine', [
            ['male', 18, 150, 62, 115, 'мкмоль/л', 'normal', 'Взрослые мужчины'],
            ['female', 18, 150, 53, 97, 'мкмоль/л', 'normal', 'Взрослые женщины'],
        ]);

        $this->add('egfr', [
            [null, 18, 150, 90, null, 'мл/мин/1,73 м²', 'normal', 'Обычно нормальная СКФ'],
            [null, 18, 150, 60, 89, 'мл/мин/1,73 м²', 'borderline_low', 'Оценивать в контексте'],
            [null, 18, 150, 0, 59, 'мл/мин/1,73 м²', 'critical_low', 'Требует внимания'],
        ]);

        $this->add('alt', [
            [null, 18, 150, 0, 45, 'Ед/л', 'normal', 'Ориентировочный взрослый референс'],
        ]);

        $this->add('ast', [
            [null, 18, 150, 0, 45, 'Ед/л', 'normal', 'Ориентировочный взрослый референс'],
        ]);

        $this->add('ggt', [
            ['male', 18, 150, 0, 55, 'Ед/л', 'normal', 'Взрослые мужчины'],
            ['female', 18, 150, 0, 38, 'Ед/л', 'normal', 'Взрослые женщины'],
        ]);

        $this->add('bilirubin-total', [
            [null, 18, 150, 3, 21, 'мкмоль/л', 'normal', 'Взрослые'],
        ]);

        $this->add('total-cholesterol', [
            [null, 18, 150, 0, 5.0, 'ммоль/л', 'normal', 'Желательный уровень'],
            [null, 18, 150, 5.0, 6.2, 'ммоль/л', 'borderline_high', 'Погранично повышен'],
            [null, 18, 150, 6.2, null, 'ммоль/л', 'critical_high', 'Повышен'],
        ]);

        $this->add('ldl', [
            [null, 18, 150, 0, 3.0, 'ммоль/л', 'normal', 'Цель зависит от сердечно-сосудистого риска'],
            [null, 18, 150, 3.0, 4.9, 'ммоль/л', 'borderline_high', 'Оценивать по риску'],
            [null, 18, 150, 4.9, null, 'ммоль/л', 'critical_high', 'Повышен'],
        ]);

        $this->add('hdl', [
            ['male', 18, 150, 1.0, null, 'ммоль/л', 'normal', 'Желательно выше'],
            ['female', 18, 150, 1.2, null, 'ммоль/л', 'normal', 'Желательно выше'],
        ]);

        $this->add('triglycerides', [
            [null, 18, 150, 0, 1.7, 'ммоль/л', 'normal', 'Желательный уровень'],
            [null, 18, 150, 1.7, 2.3, 'ммоль/л', 'borderline_high', 'Погранично повышены'],
            [null, 18, 150, 2.3, null, 'ммоль/л', 'critical_high', 'Повышены'],
        ]);

        $this->add('ferritin', [
            ['male', 18, 150, 30, 400, 'мкг/л', 'normal', 'Взрослые мужчины'],
            ['female', 18, 150, 15, 150, 'мкг/л', 'normal', 'Взрослые женщины'],
        ]);

        $this->add('serum-iron', [
            [null, 18, 150, 9, 30, 'мкмоль/л', 'normal', 'Взрослые'],
        ]);

        $this->add('tsh', [
            [null, 18, 150, 0.4, 4.0, 'мЕд/л', 'normal', 'Взрослые'],
        ]);

        $this->add('free-t4', [
            [null, 18, 150, 10, 22, 'пмоль/л', 'normal', 'Взрослые'],
        ]);

        $this->add('free-t3', [
            [null, 18, 150, 3.1, 6.8, 'пмоль/л', 'normal', 'Взрослые'],
        ]);

        $this->add('crp', [
            [null, 18, 150, 0, 5, 'мг/л', 'normal', 'Обычно'],
            [null, 18, 150, 5, null, 'мг/л', 'critical_high', 'Повышен'],
        ]);

        $this->add('vitamin-d', [
            [null, 18, 150, 0, 20, 'нг/мл', 'critical_low', 'Дефицит'],
            [null, 18, 150, 20, 30, 'нг/мл', 'borderline_low', 'Недостаточность'],
            [null, 18, 150, 30, 50, 'нг/мл', 'normal', 'Достаточный уровень'],
            [null, 18, 150, 100, null, 'нг/мл', 'critical_high', 'Возможный избыток'],
        ]);

        $this->add('vitamin-b12', [
            [null, 18, 150, 200, 900, 'пг/мл', 'normal', 'Взрослые'],
        ]);

        $this->add('folate', [
            [null, 18, 150, 3, 17, 'нг/мл', 'normal', 'Взрослые'],
        ]);

        $this->add('inr', [
            [null, 18, 150, 0.8, 1.2, 'коэффициент', 'normal', 'Без антикоагулянтной терапии'],
        ]);

        $this->add('fibrinogen', [
            [null, 18, 150, 2, 4, 'г/л', 'normal', 'Взрослые'],
        ]);
    }

    private function add(string $slug, array $ranges): void
    {
        $marker = Marker::where('slug', $slug)->first();

        if (! $marker) {
            $this->command?->warn("Marker not found: {$slug}");
            return;
        }

        foreach ($ranges as [$gender, $ageMin, $ageMax, $min, $max, $unit, $statusType, $note]) {
            MarkerRange::updateOrCreate(
                [
                    'marker_id' => $marker->id,
                    'gender' => $gender,
                    'age_min' => $ageMin,
                    'age_max' => $ageMax,
                    'min_value' => $min,
                    'max_value' => $max,
                    'unit' => $unit,
                    'status_type' => $statusType,
                ],
                [
                    'note' => $note,
                    'source' => 'DSlog MVP reference ranges',
                ]
            );
        }
    }
}