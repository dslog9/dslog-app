<?php

namespace App\Services;

class AiService
{
    public function analyze($text)
    {
        $text = trim((string) $text);

        return [
            'summary' => 'Обнаружено отклонение от нормы',
            'details' => 'Гемоглобин ниже нормы',
            'risks' => [
                'Возможна анемия',
                'Важно оценивать результат вместе с ферритином, эритроцитами и гематокритом',
            ],
            'recommendations' => [
                'Проверьте ферритин и показатели общего анализа крови',
                'Обратитесь к врачу, если есть слабость, одышка, головокружение или выраженная усталость',
            ],
            'items' => [
                [
                    'marker_code' => 'hemoglobin',
                    'marker_name' => 'Гемоглобин',
                    'marker_label' => 'Гемоглобин',
                    'value' => 110,
                    'value_text' => '110',
                    'unit' => 'г/л',
                    'reference_range' => '120–160',
                    'status' => 'low',
                ],
            ],
        ];
    }
}