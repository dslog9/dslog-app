<?php

namespace App\Services\Internal;

use App\Models\Marker;
use Illuminate\Support\Collection;

class MarkerCoverageReadinessService
{
    public function enrich(Collection $markers): Collection
    {
        return $markers->map(function (Marker $marker) {
            $scores = $this->calculateScores($marker);

            $marker->coverage_scores = $scores;
            $marker->readiness_score = $scores['readiness'];
            $marker->readiness_status = $this->status($scores['readiness']);
            $marker->coverage_issues = $this->issues($marker);
            
            return $marker;
        });
    }

    public function calculateScores(Marker $marker): array
    {
        $applicabilityScore = $marker->profileApplicabilities->count() > 0 ? 100 : 0;

        $applicableProfileIds = $marker->profileApplicabilities
            ->where('applicability_status', 'applicable')
            ->pluck('scoring_profile_id')
            ->unique();

        $ruleProfileIds = $marker->scoringRules
            ->where('is_active', true)
            ->pluck('scoring_profile_id')
            ->unique();

        $missingRuleIds = $applicableProfileIds->diff($ruleProfileIds);

        $scoringScore = $applicableProfileIds->count() > 0
            ? round((($applicableProfileIds->count() - $missingRuleIds->count()) / $applicableProfileIds->count()) * 100)
            : 0;

        $rangesScore = $marker->ranges->count() > 0 ? 100 : 0;

        $synonymsCount = $marker->synonyms->count();

        $synonymsScore = match (true) {
            $synonymsCount >= 5 => 100,
            $synonymsCount >= 3 => 75,
            $synonymsCount >= 1 => 40,
            default => 0,
        };

        $contentChecks = [
            !empty($marker->description),
            !empty($marker->short),
            !empty($marker->what_is),
            !empty($marker->interpretation),
            !empty($marker->norms),
            !empty($marker->low),
            !empty($marker->high),
            !empty($marker->what_to_do),
            !empty($marker->when_to_test),
            !empty($marker->preparation),
            !empty($marker->page_blocks),
            !empty($marker->title),
            !empty($marker->h1),
            !empty($marker->seo_description),
            !empty($marker->seo_intro),
            $marker->faqs->count() > 0,
            $marker->relations->count() > 0,
        ];

        $contentScore = round(
            (collect($contentChecks)->filter()->count() / count($contentChecks)) * 100
        );

        $panelCount = $marker->testPanels->count();
        $panelMarkers = $marker->testPanelMarkers;

        if ($panelCount === 0) {
            $panelsScore = 0;
        } else {
            $panelsWithFrequency = $panelMarkers
                ->filter(fn ($item) => !empty($item->frequency_months))
                ->count();

            $panelsWithRole = $panelMarkers
                ->filter(fn ($item) => !empty($item->role))
                ->count();

            $panelsScore = round(($panelsWithFrequency / $panelCount) * 50)
                + round(($panelsWithRole / $panelCount) * 50);
        }

        $readinessScore = round(
            ($applicabilityScore * 0.20)
            + ($scoringScore * 0.25)
            + ($rangesScore * 0.15)
            + ($synonymsScore * 0.10)
            + ($contentScore * 0.20)
            + ($panelsScore * 0.10)
        );

        return [
            'applicability' => $applicabilityScore,
            'scoring' => $scoringScore,
            'ranges' => $rangesScore,
            'synonyms' => $synonymsScore,
            'content' => $contentScore,
            'panels' => $panelsScore,
            'readiness' => $readinessScore,
        ];
    }

        public function issues(Marker $marker): array
        {
            $issues = [];

            if ($marker->profileApplicabilities->count() === 0) {
                $issues[] = 'No applicability matrix';
            }

            $applicableProfileIds = $marker->profileApplicabilities
                ->where('applicability_status', 'applicable')
                ->pluck('scoring_profile_id')
                ->unique();

            $ruleProfileIds = $marker->scoringRules
                ->where('is_active', true)
                ->pluck('scoring_profile_id')
                ->unique();

            if ($applicableProfileIds->diff($ruleProfileIds)->count() > 0) {
                $issues[] = 'Missing scoring rules';
            }

            if ($marker->ranges->count() === 0) {
                $issues[] = 'No ranges';
            }

            if ($marker->synonyms->count() < 3) {
                $issues[] = 'Weak synonyms';
            }

            if (($marker->coverage_scores['content'] ?? 0) < 60) {
                $issues[] = 'Weak content';
            }

            if ($marker->testPanels->count() === 0) {
                $issues[] = 'Not used in panels';
            }

            return $issues;
        }




    private function status(int $score): string
    {
        if ($score >= 85) {
            return 'strong';
        }

        if ($score >= 60) {
            return 'partial';
        }

        return 'weak';
    }
}