<?php

namespace App\Services;

class TextLabParserService
{
    private array $markers = [
        'hemoglobin' => [
            'marker_code' => 'hemoglobin',
            'marker_name' => 'Гемоглобин',
            'patterns' => [
                'гемоглобин',
                'hemoglobin',
                'hgb',
                'hb',
            ],
            'default_unit' => 'г/л',
        ],

        'ferritin' => [
            'marker_code' => 'ferritin',
            'marker_name' => 'Ферритин',
            'patterns' => [
                'ферритин',
                'ferritin',
            ],
            'default_unit' => 'нг/мл',
        ],

        'crp' => [
            'marker_code' => 'crp',
            'marker_name' => 'С-реактивный белок',
            'patterns' => [
                'crp',
                'срб',
                'с-реактивный белок',
                'c-reactive protein',
            ],
            'default_unit' => 'мг/л',
        ],

        'hdl' => [
            'marker_code' => 'hdl',
            'marker_name' => 'ЛПВП',
            'patterns' => [
                'hdl',
                'лпвп',
                'холестерин лпвп',
            ],
            'default_unit' => 'ммоль/л',
        ],

        'ldl' => [
            'marker_code' => 'ldl',
            'marker_name' => 'ЛПНП',
            'patterns' => [
                'ldl',
                'лпнп',
                'холестерин лпнп',
            ],
            'default_unit' => 'ммоль/л',
        ],

        'glucose' => [
            'marker_code' => 'glucose',
            'marker_name' => 'Глюкоза',
            'patterns' => [
                'глюкоза',
                'glucose',
            ],
            'default_unit' => 'ммоль/л',
        ],

        'tsh' => [
            'marker_code' => 'tsh',
            'marker_name' => 'ТТГ',
            'patterns' => [
                'ттг',
                'tsh',
            ],
            'default_unit' => 'мМЕ/л',
        ],
    ];

    public function parse(string $text): array
    {
        $items = [];
        $usedMarkers = [];

        $lines = preg_split('/\R/u', $text) ?: [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parsed = $this->parseLine($line);

            if (!$parsed) {
                continue;
            }

            if (isset($usedMarkers[$parsed['marker_code']])) {
                continue;
            }

            $usedMarkers[$parsed['marker_code']] = true;
            $items[] = $parsed;
        }

        return $items;
    }

    private function parseLine(string $line): ?array
    {
        $normalizedLine = mb_strtolower($line);

        foreach ($this->markers as $marker) {
            foreach ($marker['patterns'] as $pattern) {
                if (!str_contains($normalizedLine, mb_strtolower($pattern))) {
                    continue;
                }

                $value = $this->extractValue($line);

                if ($value === null) {
                    return null;
                }

                $unit = $this->extractUnit($line) ?? $marker['default_unit'];

                return [
                    'marker_code' => $marker['marker_code'],
                    'marker_name' => $marker['marker_name'],
                    'marker_label' => $marker['marker_name'],
                    'value' => $value,
                    'value_text' => (string) $value,
                    'unit' => $unit,
                    'reference_range' => null,
                    'status' => null,
                ];
            }
        }

        return null;
    }

    private function extractValue(string $line): ?float
    {
        if (!preg_match('/(-?\d+(?:[.,]\d+)?)/u', $line, $matches)) {
            return null;
        }

        return (float) str_replace(',', '.', $matches[1]);
    }

    private function extractUnit(string $line): ?string
    {
        $units = [
            'г/л',
            'мг/л',
            'ммоль/л',
            'мкмоль/л',
            'нг/мл',
            'мме/л',
            'ме/л',
            'ед/л',
            '%',
        ];

        $normalizedLine = mb_strtolower($line);

        foreach ($units as $unit) {
            if (str_contains($normalizedLine, $unit)) {
                return $unit;
            }
        }

        return null;
    }
}