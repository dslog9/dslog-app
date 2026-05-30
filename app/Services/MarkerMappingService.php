<?php

namespace App\Services;

use App\Models\AnalysisItem;
use App\Models\Marker;
use App\Models\MarkerSynonym;

class MarkerMappingService
{
    public function mapAnalysisItem(AnalysisItem $item): ?Marker
    {
        $candidates = array_filter([
            $item->marker_code,
            $item->marker_name,
            $item->marker_label,
        ]);

        foreach ($candidates as $candidate) {
            $normalized = $this->normalize($candidate);

            $marker = Marker::query()
                ->whereRaw('LOWER(code) = ?', [$normalized])
                ->orWhereRaw('LOWER(slug) = ?', [$normalized])
                ->orWhereRaw('LOWER(name) = ?', [$normalized])
                ->first();

            if ($marker) {
                $item->update(['marker_id' => $marker->id]);
                return $marker;
            }

            $synonym = MarkerSynonym::query()
                ->whereRaw('LOWER(name) = ?', [$normalized])
                ->first();

            if ($synonym?->marker) {
                $item->update(['marker_id' => $synonym->marker_id]);
                return $synonym->marker;
            }
        }

        return null;
    }

    public function mapAnalysisItems(int $analysisId): int
    {
        $mapped = 0;

        AnalysisItem::where('analysis_id', $analysisId)
            ->whereNull('marker_id')
            ->each(function (AnalysisItem $item) use (&$mapped) {
                if ($this->mapAnalysisItem($item)) {
                    $mapped++;
                }
            });

        return $mapped;
    }

    private function normalize(string $value): string
    {
        return mb_strtolower(trim($value));
    }
}