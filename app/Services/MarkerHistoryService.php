<?php

namespace App\Services;

use App\Models\AnalysisItem;
use Illuminate\Support\Collection;

class MarkerHistoryService
{
    public function getMarkerHistory(
        int $markerId,
        ?int $userId = null,
        int $limit = 100
    ): Collection {

        return AnalysisItem::query()
            ->with([
                'analysis',
                'latestEvaluation',
                'marker',
            ])
            ->where('marker_id', $markerId)
            ->whereNotNull('value')
            ->whereHas('analysis', function ($query) use ($userId) {

                if ($userId !== null) {
                    $query->where('user_id', $userId);
                } else {
                    $query->whereNull('user_id');
                }
            })
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->sortBy('created_at')
            ->values();
    }
}