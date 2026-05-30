<?php

namespace App\Services\Charts;

use App\DTO\Charts\ChartZone;
use App\Models\MarkerScoringRule;

class MarkerChartZoneService
{
    /**
     * @return ChartZone[]
     */
    public function build(MarkerScoringRule $rule): array
    {
        return array_values(array_filter([

            new ChartZone(
                null,
                $rule->critical_low_max,
                'critical_low',
                'Critical low',
                10
            ),

            new ChartZone(
                $rule->critical_low_max,
                $rule->needs_control_low_max,
                'needs_control_low',
                'Needs control low',
                20
            ),

            new ChartZone(
                $rule->needs_control_low_max,
                $rule->borderline_low_max,
                'borderline_low',
                'Borderline low',
                30
            ),

            new ChartZone(
                $rule->optimal_min,
                $rule->optimal_max,
                'optimal',
                'Optimal',
                50
            ),

            new ChartZone(
                $rule->exceptional_min,
                $rule->exceptional_max,
                'exceptional',
                'Exceptional',
                60
            ),

            new ChartZone(
                $rule->borderline_high_min,
                $rule->needs_control_high_min,
                'borderline_high',
                'Borderline high',
                70
            ),

            new ChartZone(
                $rule->needs_control_high_min,
                $rule->critical_high_min,
                'needs_control_high',
                'Needs control high',
                80
            ),

            new ChartZone(
                $rule->critical_high_min,
                null,
                'critical_high',
                'Critical high',
                90
            ),

        ], fn (?ChartZone $zone) => !(
            $zone?->from === null
            && $zone?->to === null
        )));
    }
}