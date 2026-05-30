<?php

namespace App\Services;

use App\Models\AnalysisItem;
use App\Models\MarkerScoringProfile;
use App\Models\MarkerScoringRule;

class MarkerScoringService
{
    public function evaluateAnalysisItem(
        AnalysisItem $item,
        ?MarkerScoringProfile $profile = null
    ): string {
        if (!$item->marker_id || $item->value === null) {
            return 'unknown';
        }

        $profile ??= MarkerScoringProfile::where('is_default', true)
            ->where('is_active', true)
            ->first();

        if (!$profile) {
            return 'unknown';
        }

        $rule = MarkerScoringRule::where('marker_id', $item->marker_id)
            ->where('scoring_profile_id', $profile->id)
            ->where('is_active', true)
            ->first();

        if (!$rule) {
            return 'unknown';
        }

        return $this->evaluateValue((float) $item->value, $rule);
    }

    public function evaluateValue(float $value, MarkerScoringRule $rule): string
    {
        if ($rule->direction === 'higher_better') {
            return $this->evaluateHigherBetter($value, $rule);
        }

        if ($rule->direction === 'lower_better') {
            return $this->evaluateLowerBetter($value, $rule);
        }

        return $this->evaluateRange($value, $rule);
    }

    private function evaluateRange(float $value, MarkerScoringRule $rule): string
    {
        if ($rule->critical_low_max !== null && $value <= $rule->critical_low_max) {
            return 'urgent';
        }

        if ($rule->needs_control_low_max !== null && $value <= $rule->needs_control_low_max) {
            return 'needs_control';
        }

        if ($rule->borderline_low_max !== null && $value <= $rule->borderline_low_max) {
            return 'borderline';
        }

        if (
            $rule->exceptional_min !== null &&
            $rule->exceptional_max !== null &&
            $value >= $rule->exceptional_min &&
            $value <= $rule->exceptional_max
        ) {
            return 'exceptional';
        }

        if (
            $rule->optimal_min !== null &&
            $rule->optimal_max !== null &&
            $value >= $rule->optimal_min &&
            $value <= $rule->optimal_max
        ) {
            return 'optimal';
        }

        if ($rule->critical_high_min !== null && $value >= $rule->critical_high_min) {
            return 'urgent';
        }

        if ($rule->needs_control_high_min !== null && $value >= $rule->needs_control_high_min) {
            return 'needs_control';
        }

        if ($rule->borderline_high_min !== null && $value >= $rule->borderline_high_min) {
            return 'borderline';
        }

        return 'normal';
    }

    private function evaluateHigherBetter(float $value, MarkerScoringRule $rule): string
    {
        if ($rule->critical_low_max !== null && $value <= $rule->critical_low_max) {
            return 'urgent';
        }

        if ($rule->needs_control_low_max !== null && $value <= $rule->needs_control_low_max) {
            return 'needs_control';
        }

        if ($rule->borderline_low_max !== null && $value <= $rule->borderline_low_max) {
            return 'borderline';
        }

        if (
            $rule->exceptional_min !== null &&
            $value >= $rule->exceptional_min &&
            ($rule->exceptional_max === null || $value <= $rule->exceptional_max)
        ) {
            return 'exceptional';
        }

        if (
            $rule->optimal_min !== null &&
            $value >= $rule->optimal_min &&
            ($rule->optimal_max === null || $value <= $rule->optimal_max)
        ) {
            return 'optimal';
        }

        return 'normal';
    }

    private function evaluateLowerBetter(float $value, MarkerScoringRule $rule): string
    {
        if (
            $rule->exceptional_min !== null &&
            $rule->exceptional_max !== null &&
            $value >= $rule->exceptional_min &&
            $value <= $rule->exceptional_max
        ) {
            return 'exceptional';
        }

        if (
            $rule->optimal_min !== null &&
            $rule->optimal_max !== null &&
            $value >= $rule->optimal_min &&
            $value <= $rule->optimal_max
        ) {
            return 'optimal';
        }

        if ($rule->critical_high_min !== null && $value >= $rule->critical_high_min) {
            return 'urgent';
        }

        if ($rule->needs_control_high_min !== null && $value >= $rule->needs_control_high_min) {
            return 'needs_control';
        }

        if ($rule->borderline_high_min !== null && $value >= $rule->borderline_high_min) {
            return 'borderline';
        }

        return 'normal';
    }
}