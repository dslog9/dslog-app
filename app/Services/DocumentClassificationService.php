<?php

namespace App\Services;

class DocumentClassificationService
{
    public function classify(string $text, array $items = []): array
    {
        $normalizedText = mb_strtolower($text);

        $signals = 0;
        $reasons = [];

        if (count($items) > 0 && $this->textContainsAnyLabSignal($normalizedText)) {
            $signals += 2;
            $reasons[] = 'AI/mock returned analysis items with text lab signals';
        }

        $labKeywords = [
            'гемоглобин',
            'лейкоциты',
            'эритроциты',
            'тромбоциты',
            'гематокрит',
            'ферритин',
            'глюкоза',
            'холестерин',
            'креатинин',
            'билирубин',
            'алт',
            'аст',
            'ттг',
            'crp',
            'с-реактивный',
            'hgb',
            'wbc',
            'rbc',
            'plt',
            'alt',
            'ast',
            'tsh',
            'hdl',
            'ldl',
        ];

        $keywordHits = 0;

        foreach ($labKeywords as $keyword) {
            if (str_contains($normalizedText, $keyword)) {
                $keywordHits++;
            }
        }

        if ($keywordHits >= 2) {
            $signals += 2;
            $reasons[] = 'Detected multiple laboratory marker keywords';
        } elseif ($keywordHits === 1) {
            $signals += 1;
            $reasons[] = 'Detected one laboratory marker keyword';
        }

        $unitPatterns = [
            '/\b\d+([.,]\d+)?\s*(г\/л|г\/дл|мг\/л|ммоль\/л|мкмоль\/л|ед\/л|u\/l|iu\/l|ng\/ml|нг\/мл|pg\/ml|пг\/мл|%)\b/ui',
            '/\b\d+([.,]\d+)?\s*x\s*10\^?\d+\b/ui',
        ];

        $unitHits = 0;

        foreach ($unitPatterns as $pattern) {
            if (preg_match_all($pattern, $text, $matches)) {
                $unitHits += count($matches[0]);
            }
        }

        if ($unitHits >= 3) {
            $signals += 2;
            $reasons[] = 'Detected multiple numeric values with laboratory units';
        } elseif ($unitHits > 0) {
            $signals += 1;
            $reasons[] = 'Detected numeric values with laboratory units';
        }

        $structureKeywords = [
            'референс',
            'референсные значения',
            'норма',
            'результат',
            'единицы',
            'биоматериал',
            'анализ крови',
            'лаборатория',
            'reference',
            'result',
            'unit',
            'normal range',
        ];

        $structureHits = 0;

        foreach ($structureKeywords as $keyword) {
            if (str_contains($normalizedText, $keyword)) {
                $structureHits++;
            }
        }

        if ($structureHits >= 2) {
            $signals += 2;
            $reasons[] = 'Detected laboratory report structure words';
        } elseif ($structureHits === 1) {
            $signals += 1;
            $reasons[] = 'Detected one laboratory report structure word';
        }

        if ($signals >= 3) {
            return [
                'document_type' => 'lab_analysis',
                'confidence' => 'medium',
                'reason' => implode('; ', $reasons),
                'signals' => $signals,
            ];
        }

        return [
            'document_type' => 'other',
            'confidence' => 'medium',
            'reason' => $reasons
                ? implode('; ', $reasons)
                : 'No laboratory analysis signals detected',
            'signals' => $signals,
        ];
    }

    private function textContainsAnyLabSignal(string $normalizedText): bool
    {
        $signals = [
            'гемоглобин',
            'лейкоциты',
            'эритроциты',
            'тромбоциты',
            'гематокрит',
            'ферритин',
            'глюкоза',
            'холестерин',
            'креатинин',
            'билирубин',
            'алт',
            'аст',
            'ттг',
            'crp',
            'с-реактивный',
            'hgb',
            'wbc',
            'rbc',
            'plt',
            'alt',
            'ast',
            'tsh',
            'hdl',
            'ldl',
            'референс',
            'норма',
            'результат',
            'единицы',
            'анализ крови',
            'лаборатория',
        ];

        foreach ($signals as $signal) {
            if (str_contains($normalizedText, $signal)) {
                return true;
            }
        }

        return false;
    }


}