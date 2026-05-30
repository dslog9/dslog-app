<?php

namespace App\Services;

use App\Models\AnalysisItem;
use App\Models\AnalysisItemEvaluation;
use App\Models\MarkerScoringProfile;
use App\Models\MarkerScoringRule;

class AnalysisItemEvaluationService
{
    public function evaluateAndSave(
        AnalysisItem $item,
        ?MarkerScoringProfile $profile = null
    ): AnalysisItemEvaluation {
        $profile ??= MarkerScoringProfile::where('is_default', true)
            ->where('is_active', true)
            ->first();

        $rule = null;
        $status = 'unknown';

        if ($item->marker_id && $item->value !== null && $profile) {
            $rule = MarkerScoringRule::where('marker_id', $item->marker_id)
                ->where('scoring_profile_id', $profile->id)
                ->where('is_active', true)
                ->first();

            if ($rule) {
                $status = app(MarkerScoringService::class)
                    ->evaluateValue((float) $item->value, $rule);
            }
        }

        return AnalysisItemEvaluation::updateOrCreate(
            [
                'analysis_item_id' => $item->id,
                'marker_scoring_profile_id' => $profile?->id,
            ],
            [
                'marker_id' => $item->marker_id,
                'marker_scoring_rule_id' => $rule?->id,
                'status' => $status,
                'direction' => $rule?->direction,
                'value' => $item->value,
                'unit' => $item->unit,
                'applied_thresholds' => $rule ? $this->thresholdsFromRule($rule) : null,
                'explanation' => [
                    'status' => $status,
                    'message' => $this->messageForStatus($status),
                ],
            ]
        );
    }

    public function evaluateAnalysisItems(int $analysisId): int
    {
        $items = AnalysisItem::where('analysis_id', $analysisId)->get();

        $count = 0;

        foreach ($items as $item) {
            $this->evaluateAndSave($item);
            $count++;
        }

        return $count;
    }

    private function thresholdsFromRule(MarkerScoringRule $rule): array
    {
        return [
            'direction' => $rule->direction,

            'critical_low_max' => $rule->critical_low_max,
            'needs_control_low_max' => $rule->needs_control_low_max,
            'borderline_low_max' => $rule->borderline_low_max,

            'optimal_min' => $rule->optimal_min,
            'optimal_max' => $rule->optimal_max,

            'exceptional_min' => $rule->exceptional_min,
            'exceptional_max' => $rule->exceptional_max,

            'borderline_high_min' => $rule->borderline_high_min,
            'needs_control_high_min' => $rule->needs_control_high_min,
            'critical_high_min' => $rule->critical_high_min,

            'unit' => $rule->unit,
            'source' => $rule->source,
        ];
    }

    private function messageForStatus(string $status): string
    {
        return match ($status) {
            'exceptional' => 'Exceptional result.',
            'optimal' => 'Optimal result.',
            'normal' => 'Good result within the expected range.',
            'borderline' => 'This result deserves attention.',
            'needs_control' => 'This result should be monitored.',
            'urgent' => 'This result shows a significant deviation.',
            default => 'Not enough data to evaluate this result.',
        };
    }
}