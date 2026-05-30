<?php

namespace App\Http\Controllers\Internal\Controls;

use App\Http\Controllers\Controller;
use App\Models\Marker;
use Illuminate\Http\Request;
use App\Models\MarkerScoringProfile;
use App\Models\MarkerProfileApplicability;
use App\Models\MarkerScoringRule;
use App\Services\Internal\MarkerCoverageReadinessService;

class MarkerCoverageController extends Controller
{
    public function index(Request $request, MarkerCoverageReadinessService $readinessService)
    {
        $allowedLayers = [
            'applicability',
            'scoring',
            'ranges',
            'synonyms',
            'content',
            'issues',
            'panels',
            'profiles',
            'readiness',
        ];

        $layer = $request->get('layer', 'applicability');

        if (! in_array($layer, $allowedLayers, true)) {
            $layer = 'applicability';
        }

        $markers = Marker::query()
            ->where('is_active', true)
            ->with([
                'profileApplicabilities.scoringProfile',
                'scoringRules.scoringProfile',
                'ranges',
                'synonyms',
                'faqs',
                'relations',
                'testPanels',
                'testPanelMarkers',

            ])
            ->withCount([
                'profileApplicabilities',
                'scoringRules',
                'ranges',
                'synonyms',
                'faqs',
                'relations',
                'testPanels',
                'testPanelMarkers',
            ])
            ->orderBy('name')
            ->get();
        
        $markers = $readinessService->enrich($markers);
        $markers = $readinessService->enrich($markers);
        $profiles = collect();

        $sort = $request->get('sort');

        if ($layer === 'readiness') {
            if ($sort === 'readiness_asc') {
                $markers = $markers->sortBy('readiness_score')->values();
            }

            if ($sort === 'readiness_desc') {
                $markers = $markers->sortByDesc('readiness_score')->values();
            }
        }

        $status = $request->get('status');

        if ($layer === 'readiness') {
            if (in_array($status, ['weak', 'partial', 'strong'], true)) {
                $markers = $markers
                    ->filter(fn ($marker) => $marker->readiness_status === $status)
                    ->values();
            }
        }



        if ($layer === 'profiles') {
            $profiles = MarkerScoringProfile::query()
                ->where('is_active', true)
                ->orderBy('profile_type')
                ->orderBy('name')
                ->get()
                ->map(function ($profile) {
                    $applicabilities = MarkerProfileApplicability::query()
                        ->where('scoring_profile_id', $profile->id)
                        ->where('is_active', true)
                        ->with('marker')
                        ->get();

                    $applicable = $applicabilities
                        ->where('applicability_status', 'applicable');

                    $needsReview = $applicabilities
                        ->where('applicability_status', 'needs_review');

                    $notApplicable = $applicabilities
                        ->where('applicability_status', 'not_applicable');

                    $ruleMarkerIds = MarkerScoringRule::query()
                        ->where('scoring_profile_id', $profile->id)
                        ->where('is_active', true)
                        ->pluck('marker_id')
                        ->unique();

                    $applicableMarkerIds = $applicable
                        ->pluck('marker_id')
                        ->unique();

                    $missingRuleMarkerIds = $applicableMarkerIds
                        ->diff($ruleMarkerIds);

                    $profile->applicability_total = $applicabilities->count();
                    $profile->applicable_count = $applicable->count();
                    $profile->needs_review_count = $needsReview->count();
                    $profile->not_applicable_count = $notApplicable->count();
                    $profile->scoring_rules_count = $ruleMarkerIds->count();
                    $profile->missing_rules_count = $missingRuleMarkerIds->count();

                    $profile->coverage_percent = $applicableMarkerIds->count() > 0
                        ? round((($applicableMarkerIds->count() - $missingRuleMarkerIds->count()) / $applicableMarkerIds->count()) * 100)
                        : null;

                    $profile->missing_rule_markers = $applicable
                        ->whereIn('marker_id', $missingRuleMarkerIds)
                        ->pluck('marker.name')
                        ->filter()
                        ->values();

                    return $profile;
                });
        }

        $activeScoringProfilesCount = MarkerScoringProfile::query()
            ->where('is_active', true)
            ->count();



        return view('internal.controls.markers.index', [
            'markers' => $markers,
            'layer' => $layer,
            'allowedLayers' => $allowedLayers,
            'profiles' => $profiles,
            'activeScoringProfilesCount' => $activeScoringProfilesCount,
            'sort' => $sort,
            'status' => $status,
        ]);
    }
}