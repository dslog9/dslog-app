<?php

namespace App\Services;

use App\Models\AnalysisItem;
use App\Models\UserProfile;

class AnalysisItemStatusService
{
    public function updateItemStatus(AnalysisItem $item, ?UserProfile $profile = null): ?string
    {
        if (! $item->marker) {
            return null;
        }

        if ($item->value === null) {
            return null;
        }

        $value = (float) $item->value;

        $gender = $profile?->gender;
        $age = $profile?->birth_year
            ? now()->year - $profile->birth_year
            : null;

        $range = app(RangeResolverService::class)
            ->resolve($item->marker, $gender, $age);

        if (! $range) {
            return null;
        }

        $status = app(RangeResolverService::class)
            ->evaluate($value, $range);

        $item->update([
            'status' => $status,
        ]);

        return $status;
    }

    public function updateAnalysisItems(int $analysisId, ?UserProfile $profile = null): int
    {
        $updated = 0;

        AnalysisItem::query()
            ->where('analysis_id', $analysisId)
            ->whereNotNull('marker_id')
            ->each(function (AnalysisItem $item) use ($profile, &$updated) {
                if ($this->updateItemStatus($item, $profile)) {
                    $updated++;
                }
            });

        return $updated;
    }
}