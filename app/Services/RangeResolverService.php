<?php

namespace App\Services;

use App\Models\Marker;
use App\Models\MarkerRange;

class RangeResolverService
{
    public function resolve(Marker $marker, ?string $gender = null, ?int $age = null): ?MarkerRange
    {
        $query = $marker->ranges();

        if ($gender) {
            $query->where(function ($q) use ($gender) {
                $q->where('gender', $gender)
                    ->orWhereNull('gender');
            });
        } else {
            $query->whereNull('gender');
        }

        if ($age) {
            $query->where(function ($q) use ($age) {
                $q->whereNull('age_min')->orWhere('age_min', '<=', $age);
            });

            $query->where(function ($q) use ($age) {
                $q->whereNull('age_max')->orWhere('age_max', '>=', $age);
            });
        }

        return $query
            ->orderByRaw('gender IS NULL ASC')
            ->orderBy('status_type')
            ->first();
    }

    public function evaluate(float $value, MarkerRange $range): string
    {
        if ($range->min_value !== null && $value < (float) $range->min_value) {
            return 'low';
        }

        if ($range->max_value !== null && $value > (float) $range->max_value) {
            return 'high';
        }

        return match ($range->status_type) {
            'borderline_low' => 'borderline_low',
            'borderline_high' => 'borderline_high',
            'critical_low' => 'critical_low',
            'critical_high' => 'critical_high',
            default => 'normal',
        };
    }
}