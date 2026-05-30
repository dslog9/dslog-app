<?php

namespace App\Services;

use App\Models\MarkerScoringRule;
use App\Services\Charts\MarkerChartZoneService;
use Illuminate\Support\Collection;

class MarkerChartDataService
{
    public function build(Collection $history): array
    {
        $items = $history
            ->filter(fn($item) => $item->value !== null)
            ->values();

        if ($items->isEmpty()) {
            return [
                'points' => [],
                'lines' => [],
                'zones' => [],
                'scale_min' => null,
                'scale_max' => null,
            ];
        }

        $values = $items
            ->pluck('value')
            ->map(fn($v) => (float) $v);

        $scaleMin = $values->min();
        $scaleMax = $values->max();

        $referenceMin = null;
        $referenceMax = null;

        $firstReference = $items
            ->pluck('reference_range')
            ->filter()
            ->first();

        if ($firstReference && preg_match('/(\d+(?:[.,]\d+)?)\s*[-–]\s*(\d+(?:[.,]\d+)?)/u', $firstReference, $matches)) {
            $referenceMin = (float) str_replace(',', '.', $matches[1]);
            $referenceMax = (float) str_replace(',', '.', $matches[2]);

            $scaleMin = min($scaleMin, $referenceMin);
            $scaleMax = max($scaleMax, $referenceMax);
        }

        $markerId = $items->first()?->marker_id;

        $scoringRule = $markerId
            ? MarkerScoringRule::query()
                ->where('marker_id', $markerId)
                ->where('is_active', true)
                ->first()
            : null;

        $chartZones = [];

        if ($scoringRule) {
            $chartZones = app(MarkerChartZoneService::class)->build($scoringRule);

            foreach ($chartZones as $zone) {
                if ($zone->from !== null) {
                    $scaleMin = min($scaleMin, $zone->from);
                    $scaleMax = max($scaleMax, $zone->from);
                }

                if ($zone->to !== null) {
                    $scaleMin = min($scaleMin, $zone->to);
                    $scaleMax = max($scaleMax, $zone->to);
                }
            }
        }

        if (!$scoringRule && $referenceMin !== null && $referenceMax !== null) {
            $chartZones = [
                new \App\DTO\Charts\ChartZone(
                    null,
                    $referenceMin,
                    'borderline_low',
                    'Below reference',
                    30
                ),
                new \App\DTO\Charts\ChartZone(
                    $referenceMin,
                    $referenceMax,
                    'optimal',
                    'Reference range',
                    50
                ),
                new \App\DTO\Charts\ChartZone(
                    $referenceMax,
                    null,
                    'borderline_high',
                    'Above reference',
                    70
                ),
            ];
        }

        if ($scaleMin === $scaleMax) {
            $scaleMin -= 1;
            $scaleMax += 1;
        }

        $padding = ($scaleMax - $scaleMin) * 0.2;

        $scaleMin -= $padding;
        $scaleMax += $padding;

        $normalizeY = function (float $value) use ($scaleMin, $scaleMax) {
            return 100 - ((($value - $scaleMin) / ($scaleMax - $scaleMin)) * 100);
        };

        $points = $items->map(function ($item, $index) use ($items, $normalizeY) {
            $count = max($items->count() - 1, 1);
            $x = ($index / $count) * 100;

            return [
                'x' => round($x, 2),
                'y' => round($normalizeY((float) $item->value), 2),
                'value' => (float) $item->value,
                'unit' => $item->unit,

                'timestamp' => $item->analysis?->analyzed_at
                    ? \Carbon\Carbon::parse($item->analysis->analyzed_at)->timestamp * 1000
                    : $item->created_at?->timestamp * 1000,

                'date' => $item->analysis?->analyzed_at
                    ? \Carbon\Carbon::parse($item->analysis->analyzed_at)->format('d.m.Y H:i')
                    : $item->created_at?->format('d.m.Y H:i'),

                'status' => $item->latestEvaluation?->status ?? 'unknown',
            ];
        })->toArray();

        $lines = [];

        if ($referenceMin !== null) {
            $lines[] = [
                'type' => 'reference_min',
                'label' => 'Reference Min',
                'value' => $referenceMin,
                'y' => round($normalizeY($referenceMin), 2),
            ];
        }

        if ($referenceMax !== null) {
            $lines[] = [
                'type' => 'reference_max',
                'label' => 'Reference Max',
                'value' => $referenceMax,
                'y' => round($normalizeY($referenceMax), 2),
            ];
        }

        $zones = collect($chartZones)->map(function ($zone) use ($normalizeY) {
            return [
                'type' => $zone->type,
                'label' => $zone->label,
                'from' => $zone->from,
                'to' => $zone->to,
                'y1' => $zone->to !== null ? round($normalizeY($zone->to), 2) : null,
                'y2' => $zone->from !== null ? round($normalizeY($zone->from), 2) : null,
                'priority' => $zone->priority,
            ];
        })->values()->toArray();

        return [
            'points' => $points,
            'lines' => $lines,
            'zones' => $zones,
            'scale_min' => $scaleMin,
            'scale_max' => $scaleMax,
        ];
    }
}