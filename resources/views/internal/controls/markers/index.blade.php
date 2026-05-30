@extends('layouts.app')

@section('content')

<div class="ds-container">

    <div class="page">

        <h1>Marker Coverage</h1>

        <div class="internal-layer-tabs">
            <a href="{{ route('internal.controls.markers.index', ['layer' => 'applicability']) }}"
            class="internal-layer-tab {{ $layer === 'applicability' ? 'is-active' : '' }}">
                Applicability
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'scoring']) }}"
            class="internal-layer-tab {{ $layer === 'scoring' ? 'is-active' : '' }}">
                Scoring rules
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'ranges']) }}"
            class="internal-layer-tab {{ $layer === 'ranges' ? 'is-active' : '' }}">
                Ranges
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'synonyms']) }}"
            class="internal-layer-tab {{ $layer === 'synonyms' ? 'is-active' : '' }}">
                Synonyms
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'content']) }}"
            class="internal-layer-tab {{ $layer === 'content' ? 'is-active' : '' }}">
                Content
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'issues']) }}"
            class="internal-layer-tab {{ $layer === 'issues' ? 'is-active' : '' }}">
                Issues
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'panels']) }}"
            class="internal-layer-tab {{ $layer === 'panels' ? 'is-active' : '' }}">
                Panels
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'profiles']) }}"
            class="internal-layer-tab {{ $layer === 'profiles' ? 'is-active' : '' }}">
                Profiles
            </a>

            <a href="{{ route('internal.controls.markers.index', ['layer' => 'readiness']) }}"
            class="internal-layer-tab {{ $layer === 'readiness' ? 'is-active' : '' }}">
                Readiness
            </a>

        </div>
@php
    $summaryCards = [];

    if ($layer === 'applicability') {
        $strong = 0;
        $partial = 0;
        $weak = 0;

        foreach ($markers as $marker) {
            $totalProfiles = $marker->profileApplicabilities->count();

            $applicableCount = $marker->profileApplicabilities
                ->where('applicability_status', 'applicable')
                ->count();

            $primaryCount = $marker->profileApplicabilities
                ->where('is_primary', true)
                ->count();

            $needsReviewCount = $marker->profileApplicabilities
                ->where('applicability_status', 'needs_review')
                ->count();

            if (
                $totalProfiles >= $activeScoringProfilesCount
                && $applicableCount > 0
                && $primaryCount > 0
                && $needsReviewCount === 0
            ) {
                $strong++;
            } elseif ($totalProfiles > 0 && $applicableCount > 0) {
                $partial++;
            } else {
                $weak++;
            }
        }

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Full matrix', 'value' => $activeScoringProfilesCount],
            ['label' => 'Strong', 'value' => $strong],
            ['label' => 'Partial', 'value' => $partial],
            ['label' => 'Weak', 'value' => $weak],
        ];
    }

    if ($layer === 'scoring') {
        $complete = 0;
        $partial = 0;
        $missing = 0;
        $coverageSum = 0;
        $coverageCount = 0;

        foreach ($markers as $marker) {
            $applicableProfileIds = $marker->profileApplicabilities
                ->where('applicability_status', 'applicable')
                ->pluck('scoring_profile_id')
                ->unique();

            $ruleProfileIds = $marker->scoringRules
                ->where('is_active', true)
                ->pluck('scoring_profile_id')
                ->unique();

            $missingProfileIds = $applicableProfileIds->diff($ruleProfileIds);

            if ($applicableProfileIds->count() === 0) {
                $missing++;
                continue;
            }

            $coverage = round((($applicableProfileIds->count() - $missingProfileIds->count()) / $applicableProfileIds->count()) * 100);
            $coverageSum += $coverage;
            $coverageCount++;

            if ($coverage === 100) {
                $complete++;
            } elseif ($coverage > 0) {
                $partial++;
            } else {
                $missing++;
            }
        }

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Complete', 'value' => $complete],
            ['label' => 'Partial', 'value' => $partial],
            ['label' => 'Missing', 'value' => $missing],
            ['label' => 'Avg coverage', 'value' => $coverageCount ? round($coverageSum / $coverageCount) . '%' : '—'],
        ];
    }

    if ($layer === 'ranges') {
        $covered = $markers->filter(fn($marker) => $marker->ranges->count() > 0)->count();
        $missing = $markers->count() - $covered;

        $units = $markers
            ->flatMap(fn($marker) => $marker->ranges->pluck('unit'))
            ->filter()
            ->unique()
            ->count();

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Covered', 'value' => $covered],
            ['label' => 'Missing', 'value' => $missing],
            ['label' => 'Units', 'value' => $units],
            ['label' => 'Ranges total', 'value' => $markers->sum(fn($marker) => $marker->ranges->count())],
        ];
    }

    if ($layer === 'synonyms') {
        $strong = $markers->filter(fn($marker) => $marker->synonyms->count() >= 5)->count();
        $partial = $markers->filter(fn($marker) => $marker->synonyms->count() >= 3 && $marker->synonyms->count() < 5)->count();
        $weak = $markers->filter(fn($marker) => $marker->synonyms->count() < 3)->count();

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Strong', 'value' => $strong],
            ['label' => 'Partial', 'value' => $partial],
            ['label' => 'Weak', 'value' => $weak],
            ['label' => 'Synonyms total', 'value' => $markers->sum(fn($marker) => $marker->synonyms->count())],
        ];
    }

    if ($layer === 'content') {
        $strong = 0;
        $partial = 0;
        $weak = 0;
        $scoreSum = 0;

        foreach ($markers as $marker) {
            $checks = [
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

            $score = round((collect($checks)->filter()->count() / count($checks)) * 100);
            $scoreSum += $score;

            if ($score >= 85) {
                $strong++;
            } elseif ($score >= 60) {
                $partial++;
            } else {
                $weak++;
            }
        }

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Strong', 'value' => $strong],
            ['label' => 'Partial', 'value' => $partial],
            ['label' => 'Weak', 'value' => $weak],
            ['label' => 'Avg score', 'value' => $markers->count() ? round($scoreSum / $markers->count()) . '%' : '—'],
        ];
    }

    if ($layer === 'issues') {
        $ready = 0;
        $minor = 0;
        $needsWork = 0;
        $totalIssues = 0;

        foreach ($markers as $marker) {
            $issueCount = 0;

            if ($marker->profileApplicabilities->count() === 0) $issueCount++;
            if ($marker->ranges->count() === 0) $issueCount++;
            if ($marker->synonyms->count() < 3) $issueCount++;
            if (empty($marker->description)) $issueCount++;
            if (empty($marker->seo_intro)) $issueCount++;
            if ($marker->faqs->count() === 0) $issueCount++;
            if ($marker->relations->count() === 0) $issueCount++;

            $totalIssues += $issueCount;

            if ($issueCount === 0) {
                $ready++;
            } elseif ($issueCount <= 2) {
                $minor++;
            } else {
                $needsWork++;
            }
        }

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Ready', 'value' => $ready],
            ['label' => 'Minor gaps', 'value' => $minor],
            ['label' => 'Needs work', 'value' => $needsWork],
            ['label' => 'Total issues', 'value' => $totalIssues],
        ];
    }

    if ($layer === 'panels') {
        $covered = $markers->filter(fn($marker) => $marker->testPanels->count() > 0)->count();
        $notUsed = $markers->count() - $covered;

        $partial = $markers->filter(function ($marker) {
            if ($marker->testPanels->count() === 0) {
                return false;
            }

            return $marker->testPanelMarkers->contains(fn($item) => empty($item->frequency_months) || empty($item->role));
        })->count();

        $strong = $covered - $partial;

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Covered', 'value' => $covered],
            ['label' => 'Strong', 'value' => $strong],
            ['label' => 'Partial', 'value' => $partial],
            ['label' => 'Not used', 'value' => $notUsed],
        ];
    }

    if ($layer === 'profiles') {
        $covered = $profiles->filter(fn($profile) => $profile->coverage_percent === 100)->count();
        $partial = $profiles->filter(fn($profile) => $profile->coverage_percent !== null && $profile->coverage_percent < 100 && $profile->coverage_percent >= 50)->count();
        $weak = $profiles->filter(fn($profile) => $profile->coverage_percent === null || $profile->coverage_percent < 50)->count();

        $summaryCards = [
            ['label' => 'Profiles', 'value' => $profiles->count()],
            ['label' => 'Covered', 'value' => $covered],
            ['label' => 'Partial', 'value' => $partial],
            ['label' => 'Weak', 'value' => $weak],
            ['label' => 'Missing rules', 'value' => $profiles->sum('missing_rules_count')],
        ];
    }

    if ($layer === 'readiness') {
        $strong = 0;
        $partial = 0;
        $weak = 0;

        foreach ($markers as $marker) {
            $applicabilityScore = $marker->profileApplicabilities->count() > 0 ? 100 : 0;
            $rangesScore = $marker->ranges->count() > 0 ? 100 : 0;
            $synonymsScore = $marker->synonyms->count() >= 5 ? 100 : ($marker->synonyms->count() >= 3 ? 75 : ($marker->synonyms->count() >= 1 ? 40 : 0));
            $panelsScore = $marker->testPanels->count() > 0 ? 100 : 0;

            $readinessScore = round(
                ($applicabilityScore * 0.30)
                + ($rangesScore * 0.20)
                + ($synonymsScore * 0.20)
                + ($panelsScore * 0.30)
            );

            if ($readinessScore >= 85) {
                $strong++;
            } elseif ($readinessScore >= 60) {
                $partial++;
            } else {
                $weak++;
            }
        }

        $summaryCards = [
            ['label' => 'Markers', 'value' => $markers->count()],
            ['label' => 'Strong', 'value' => $strong],
            ['label' => 'Partial', 'value' => $partial],
            ['label' => 'Weak', 'value' => $weak],
            ['label' => 'Layers', 'value' => 6],
        ];
    }
@endphp

@if(count($summaryCards))
    <div class="internal-summary-grid">
        @foreach($summaryCards as $card)
            <div class="internal-summary-card">
                <div class="internal-summary-label">{{ $card['label'] }}</div>
                <div class="internal-summary-value">{{ $card['value'] }}</div>
            </div>
        @endforeach
    </div>
@endif

        @if($layer === 'applicability')

            <table class="internal-table">

                <thead>
                    <tr>
                        <th>Marker</th>
                        <th>Matrix</th>
                        <th>Applicable</th>
                        <th>Review</th>
                        <th>Not applicable</th>
                        <th>Primary</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($markers as $marker)

                        @php
                            $totalProfiles = $marker->profileApplicabilities->count();

                            $applicableProfiles = $marker->profileApplicabilities
                                ->where('applicability_status', 'applicable');

                            $needsReviewProfiles = $marker->profileApplicabilities
                                ->where('applicability_status', 'needs_review');

                            $notApplicableProfiles = $marker->profileApplicabilities
                                ->where('applicability_status', 'not_applicable');

                            $primaryProfiles = $marker->profileApplicabilities
                                ->where('is_primary', true);

                            $missingMatrixCount = max($activeScoringProfilesCount - $totalProfiles, 0);

                            $isFullMatrix = $missingMatrixCount === 0;
                            $hasApplicable = $applicableProfiles->count() > 0;
                            $hasPrimary = $primaryProfiles->count() > 0;
                            $hasReview = $needsReviewProfiles->count() > 0;
                        @endphp

                        <tr>

                            <td class="internal-marker-cell">
                                {{ $marker->name }}
                            </td>

                            <td>
                                @if($isFullMatrix)
                                    <span class="internal-check internal-check-ok">✓</span>
                                @else
                                    <span class="internal-check internal-check-bad">×</span>
                                @endif

                                {{ $totalProfiles }}/{{ $activeScoringProfilesCount }}

                                @if(!$isFullMatrix)
                                    <span class="status-badge">
                                        missing {{ $missingMatrixCount }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <details class="internal-details">
                                    <summary>
                                        {{ $applicableProfiles->count() }}
                                    </summary>

                                    <div class="internal-profile-list">
                                        @foreach($applicableProfiles->sortBy('priority') as $item)
                                            <div class="internal-profile-row">
                                                <div>
                                                    <strong>{{ $item->scoringProfile?->name ?? $item->scoringProfile?->slug }}</strong>
                                                    <div class="muted">{{ $item->reason }}</div>
                                                </div>
                                                @if($item->is_primary)
                                                    <span class="status-badge status-good">primary</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </td>

                            <td>
                                @if($needsReviewProfiles->count() > 0)
                                    <details class="internal-details">
                                        <summary>
                                            <span class="internal-check internal-check-bad">×</span>
                                            {{ $needsReviewProfiles->count() }}
                                        </summary>

                                        <div class="internal-profile-list">
                                            @foreach($needsReviewProfiles->sortBy('priority') as $item)
                                                <div class="internal-profile-row">
                                                    <div>
                                                        <strong>{{ $item->scoringProfile?->name ?? $item->scoringProfile?->slug }}</strong>
                                                        <div class="muted">{{ $item->reason }}</div>
                                                    </div>
                                                    <span class="status-badge status-warning">review</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </details>
                                @else
                                    <span class="internal-check internal-check-ok">✓</span>
                                    0
                                @endif
                            </td>

                            <td>
                                {{ $notApplicableProfiles->count() }}
                            </td>

                            <td>
                                @if($hasPrimary)
                                    <span class="internal-check internal-check-ok">✓</span>
                                    {{ $primaryProfiles->count() }}
                                @else
                                    <span class="internal-check internal-check-bad">×</span>
                                    none
                                @endif
                            </td>

                            <td>
                                @if($isFullMatrix && $hasApplicable && $hasPrimary && !$hasReview)

                                    <span class="status-badge status-good">
                                        Strong
                                    </span>

                                @elseif($totalProfiles > 0 && $hasApplicable)

                                    <span class="status-badge status-warning">
                                        Partial
                                    </span>

                                @else

                                    <span class="status-badge">
                                        Weak
                                    </span>

                                @endif
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @elseif($layer === 'scoring')

            <table class="internal-table">

                <thead>
                    <tr>
                        <th>Marker</th>
                        <th>Applicable profiles</th>
                        <th>Rules</th>
                        <th>Missing rules</th>
                        <th>Coverage</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($markers as $marker)

                        @php
                            $applicableProfileIds = $marker
                                ->profileApplicabilities
                                ->where('applicability_status', 'applicable')
                                ->pluck('scoring_profile_id')
                                ->unique();

                            $ruleProfileIds = $marker
                                ->scoringRules
                                ->where('is_active', true)
                                ->pluck('scoring_profile_id')
                                ->unique();

                            $missingProfileIds = $applicableProfileIds->diff($ruleProfileIds);

                            $coveragePercent = $applicableProfileIds->count() > 0
                                ? round((($applicableProfileIds->count() - $missingProfileIds->count()) / $applicableProfileIds->count()) * 100)
                                : null;

                            $missingProfiles = $marker
                                ->profileApplicabilities
                                ->whereIn('scoring_profile_id', $missingProfileIds)
                                ->where('applicability_status', 'applicable');
                        @endphp

                        <tr>

                        <td class="internal-marker-cell">
                            {{ $marker->name }}
                        </td>

                            <td>
                                {{ $applicableProfileIds->count() }}
                            </td>

                            <td>
                                <details class="internal-details">

                                    <summary>
                                        {{ $marker->scoringRules->where('is_active', true)->count() }} rules
                                    </summary>

                                    <div class="internal-profile-list">

                                        @forelse($marker->scoringRules->where('is_active', true) as $rule)

                                            <div class="internal-profile-row">

                                                <div>
                                                    <strong>
                                                        {{ $rule->scoringProfile?->name ?? $rule->scoringProfile?->slug }}
                                                    </strong>

                                                    <div class="muted">
                                                        {{ $rule->direction }} · {{ $rule->unit }}
                                                    </div>
                                                </div>

                                                <span class="status-badge status-good">
                                                    rule
                                                </span>

                                            </div>

                                        @empty

                                            <div class="muted">
                                                No scoring rules.
                                            </div>

                                        @endforelse

                                    </div>

                                </details>
                            </td>

                            <td>
                                @if($missingProfileIds->count() > 0)

                                    <details class="internal-details">

                                        <summary>
                                            <span class="status-badge status-warning">
                                                Missing: {{ $missingProfileIds->count() }}
                                            </span>
                                        </summary>

                                        <div class="internal-profile-list">

                                            @foreach($missingProfiles as $applicability)

                                                <div class="internal-profile-row">

                                                    <div>
                                                        <strong>
                                                            {{ $applicability->scoringProfile?->name ?? $applicability->scoringProfile?->slug }}
                                                        </strong>

                                                        <div class="muted">
                                                            {{ $applicability->reason }}
                                                        </div>
                                                    </div>

                                                </div>

                                            @endforeach

                                        </div>

                                    </details>

                                @else

                                    <span class="status-badge status-good">
                                        Complete
                                    </span>

                                @endif
                            </td>

                            <td>
                                @if($coveragePercent === 100)
                                    <span class="internal-check internal-check-ok">✓</span>
                                    <span>{{ $coveragePercent }}%</span>
                                @elseif($coveragePercent !== null)
                                    <span class="internal-check internal-check-bad">×</span>
                                    <span>{{ $coveragePercent }}%</span>
                                @else
                                    <span class="internal-check internal-check-ok">✓</span>
                                    <span>—</span>
                                @endif
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @elseif($layer === 'ranges')

            <table class="internal-table">

                <thead>
                    <tr>
                        <th>Marker</th>
                        <th>Ranges</th>
                        <th>Units</th>
                        <th>Gender / age coverage</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($markers as $marker)

                        @php
                            $ranges = $marker->ranges;

                            $units = $ranges
                                ->pluck('unit')
                                ->filter()
                                ->unique()
                                ->values();

                            $genderCoverage = $ranges
                                ->pluck('gender')
                                ->filter()
                                ->unique()
                                ->values();
                        @endphp

                        <tr>

                        <td class="internal-marker-cell">
                            {{ $marker->name }}
                        </td>

                            <td>
                                <details class="internal-details">

                                    <summary>
                                        {{ $ranges->count() }} ranges
                                    </summary>

                                    <div class="internal-profile-list">

                                        @forelse($ranges as $range)

                                            <div class="internal-profile-row">

                                                <div>
                                                    <strong>
                                                        {{ $range->gender ?? 'any' }}
                                                        ·
                                                        {{ $range->age_min ?? '0' }}–{{ $range->age_max ?? '∞' }}
                                                    </strong>

                                                    <div class="muted">
                                                        {{ $range->min_value ?? '—' }}
                                                        –
                                                        {{ $range->max_value ?? '—' }}
                                                        {{ $range->unit }}
                                                        ·
                                                        {{ $range->status_type }}
                                                    </div>
                                                </div>

                                            </div>

                                        @empty

                                            <div class="muted">
                                                No ranges.
                                            </div>

                                        @endforelse

                                    </div>

                                </details>
                            </td>

                            <td>
                                @if($units->count())
                                    {{ $units->join(', ') }}
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                @if($genderCoverage->count())
                                    {{ $genderCoverage->join(', ') }}
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                @if($ranges->count() === 0)

                                    <span class="status-badge status-warning">
                                        Missing ranges
                                    </span>

                                @else

                                    <span class="status-badge status-good">
                                        Covered
                                    </span>

                                @endif
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            @elseif($layer === 'synonyms')

                <table class="internal-table">

                    <thead>
                        <tr>
                            <th>Marker</th>
                            <th>Synonyms</th>
                            <th>Examples</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($markers as $marker)

                            @php
                                $synonyms = $marker->synonyms;

                                $exampleSynonyms = $synonyms
                                    ->pluck('name')
                                    ->take(5);
                            @endphp

                            <tr>

                                <td class="internal-marker-cell">
                                    {{ $marker->name }}
                                </td>

                                <td>
                                    {{ $synonyms->count() }}
                                </td>

                                <td>

                                    @if($exampleSynonyms->count())

                                        <div class="internal-inline-list">
                                            {{ $exampleSynonyms->join(', ') }}
                                        </div>

                                    @else

                                        <span class="muted">
                                            No synonyms
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($synonyms->count() >= 3)

                                        <span class="internal-check internal-check-ok">✓</span>

                                    @else

                                        <span class="internal-check internal-check-bad">×</span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @elseif($layer === 'content')

                <table class="internal-table">

                    <thead>
                        <tr>
                            <th>Marker</th>
                            <th>Core blocks</th>
                            <th>SEO</th>
                            <th>FAQ</th>
                            <th>Relations</th>
                            <th>Score</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($markers as $marker)

                            @php
                                $coreChecks = [
                                    'description' => !empty($marker->description),
                                    'short' => !empty($marker->short),
                                    'what_is' => !empty($marker->what_is),
                                    'interpretation' => !empty($marker->interpretation),
                                    'norms' => !empty($marker->norms),
                                    'low' => !empty($marker->low),
                                    'high' => !empty($marker->high),
                                    'what_to_do' => !empty($marker->what_to_do),
                                    'when_to_test' => !empty($marker->when_to_test),
                                    'preparation' => !empty($marker->preparation),
                                    'page_blocks' => !empty($marker->page_blocks),
                                ];

                                $seoChecks = [
                                    'title' => !empty($marker->title),
                                    'h1' => !empty($marker->h1),
                                    'seo_description' => !empty($marker->seo_description),
                                    'seo_intro' => !empty($marker->seo_intro),
                                ];

                                $coreDone = collect($coreChecks)->filter()->count();
                                $coreTotal = count($coreChecks);

                                $seoDone = collect($seoChecks)->filter()->count();
                                $seoTotal = count($seoChecks);

                                $faqDone = $marker->faqs->count();
                                $relationsDone = $marker->relations->count();

                                $totalDone = $coreDone + $seoDone;

                                if ($faqDone > 0) {
                                    $totalDone++;
                                }

                                if ($relationsDone > 0) {
                                    $totalDone++;
                                }

                                $totalPossible = $coreTotal + $seoTotal + 2;

                                $contentPercent = round(($totalDone / $totalPossible) * 100);

                                $missingCore = collect($coreChecks)
                                    ->filter(fn($value) => !$value)
                                    ->keys();

                                $missingSeo = collect($seoChecks)
                                    ->filter(fn($value) => !$value)
                                    ->keys();
                            @endphp

                            <tr>

                                <td class="internal-marker-cell">
                                    {{ $marker->name }}
                                </td>

                                <td>
                                    <details class="internal-details">

                                        <summary>
                                            @if($coreDone === $coreTotal)
                                                <span class="internal-check internal-check-ok">✓</span>
                                            @else
                                                <span class="internal-check internal-check-bad">×</span>
                                            @endif

                                            {{ $coreDone }}/{{ $coreTotal }}
                                        </summary>

                                        @if($missingCore->count())
                                            <div class="internal-profile-list">
                                                @foreach($missingCore as $field)
                                                    <div class="internal-profile-row">
                                                        <span>{{ $field }}</span>
                                                        <span class="status-badge">missing</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </details>
                                </td>

                                <td>
                                    <details class="internal-details">

                                        <summary>
                                            @if($seoDone === $seoTotal)
                                                <span class="internal-check internal-check-ok">✓</span>
                                            @else
                                                <span class="internal-check internal-check-bad">×</span>
                                            @endif

                                            {{ $seoDone }}/{{ $seoTotal }}
                                        </summary>

                                        @if($missingSeo->count())
                                            <div class="internal-profile-list">
                                                @foreach($missingSeo as $field)
                                                    <div class="internal-profile-row">
                                                        <span>{{ $field }}</span>
                                                        <span class="status-badge">missing</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </details>
                                </td>

                                <td>
                                    @if($faqDone > 0)
                                        <span class="internal-check internal-check-ok">✓</span>
                                    @else
                                        <span class="internal-check internal-check-bad">×</span>
                                    @endif

                                    {{ $faqDone }}
                                </td>

                                <td>
                                    @if($relationsDone > 0)
                                        <span class="internal-check internal-check-ok">✓</span>
                                    @else
                                        <span class="internal-check internal-check-bad">×</span>
                                    @endif

                                    {{ $relationsDone }}
                                </td>

                                <td>
                                    {{ $contentPercent }}%
                                </td>

                                <td>
                                    @if($contentPercent >= 85)

                                        <span class="status-badge status-good">
                                            Strong
                                        </span>

                                    @elseif($contentPercent >= 60)

                                        <span class="status-badge status-warning">
                                            Partial
                                        </span>

                                    @else

                                        <span class="status-badge">
                                            Weak
                                        </span>

                                    @endif
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @elseif($layer === 'issues')

                <table class="internal-table">

                    <thead>
                        <tr>
                            <th>Marker</th>
                            <th>Problems</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($markers as $marker)

                            @php

                                $issues = collect();

                                /*
                                |--------------------------------------------------------------------------
                                | Applicability
                                |--------------------------------------------------------------------------
                                */

                                if ($marker->profileApplicabilities->count() === 0) {
                                    $issues->push('No applicability profiles');
                                }

                                $applicableProfiles = $marker
                                    ->profileApplicabilities
                                    ->where('applicability_status', 'applicable');

                                $primaryProfiles = $marker
                                    ->profileApplicabilities
                                    ->where('is_primary', true);

                                if (
                                    $applicableProfiles->count() > 0
                                    && $primaryProfiles->count() === 0
                                ) {
                                    $issues->push('Applicable profiles without primary');
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Scoring
                                |--------------------------------------------------------------------------
                                */

                                $ruleProfileIds = $marker
                                    ->scoringRules
                                    ->where('is_active', true)
                                    ->pluck('scoring_profile_id')
                                    ->unique();

                                $applicableProfileIds = $applicableProfiles
                                    ->pluck('scoring_profile_id')
                                    ->unique();

                                $missingRuleIds = $applicableProfileIds->diff($ruleProfileIds);

                                if ($missingRuleIds->count() > 0) {
                                    $issues->push(
                                        'Missing scoring rules: ' . $missingRuleIds->count()
                                    );
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Ranges
                                |--------------------------------------------------------------------------
                                */

                                if ($marker->ranges->count() === 0) {
                                    $issues->push('No ranges');
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Synonyms
                                |--------------------------------------------------------------------------
                                */

                                if ($marker->synonyms->count() < 3) {
                                    $issues->push('Weak synonyms coverage');
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Content
                                |--------------------------------------------------------------------------
                                */

                                if (empty($marker->description)) {
                                    $issues->push('Missing description');
                                }

                                if (empty($marker->seo_intro)) {
                                    $issues->push('Missing seo_intro');
                                }

                                if ($marker->faqs->count() === 0) {
                                    $issues->push('No FAQ');
                                }

                                if ($marker->relations->count() === 0) {
                                    $issues->push('No relations');
                                }

                                $issueCount = $issues->count();

                            @endphp

                            <tr>

                                <td class="internal-marker-cell">
                                    {{ $marker->name }}
                                </td>

                                <td>

                                    @if($issueCount > 0)

                                        <details class="internal-details">

                                            <summary>
                                                <span class="internal-check internal-check-bad">
                                                    ×
                                                </span>

                                                {{ $issueCount }} issues
                                            </summary>

                                            <div class="internal-profile-list">

                                                @foreach($issues as $issue)

                                                    <div class="internal-profile-row">

                                                        <span>
                                                            {{ $issue }}
                                                        </span>

                                                        <span class="status-badge">
                                                            issue
                                                        </span>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </details>

                                    @else

                                        <span class="internal-check internal-check-ok">
                                            ✓
                                        </span>

                                        No issues

                                    @endif

                                </td>

                                <td>
                                    {{ $issueCount }}
                                </td>

                                <td>

                                    @if($issueCount === 0)

                                        <span class="status-badge status-good">
                                            Ready
                                        </span>

                                    @elseif($issueCount <= 2)

                                        <span class="status-badge status-warning">
                                            Minor gaps
                                        </span>

                                    @else

                                        <span class="status-badge">
                                            Needs work
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>                

                @elseif($layer === 'panels')

                    <table class="internal-table">

                        <thead>
                            <tr>
                                <th>Marker</th>
                                <th>Panels</th>
                                <th>Frequencies</th>
                                <th>Roles</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($markers as $marker)

                                @php
                                    $panelCount = $marker->testPanels->count();

                                    $panelMarkers = $marker->testPanelMarkers;

                                    $missingFrequencyCount = $panelMarkers
                                        ->filter(fn($item) => empty($item->frequency_months))
                                        ->count();

                                    $roles = $panelMarkers
                                        ->pluck('role')
                                        ->filter()
                                        ->unique()
                                        ->values();

                                    $panelsWithoutRole = $panelMarkers
                                        ->filter(fn($item) => empty($item->role))
                                        ->count();
                                @endphp

                                <tr>

                                    <td class="internal-marker-cell">
                                        {{ $marker->name }}
                                    </td>

                                    <td>
                                        @if($panelCount > 0)

                                            <details class="internal-details">

                                                <summary>
                                                    <span class="internal-check internal-check-ok">✓</span>
                                                    {{ $panelCount }} panels
                                                </summary>

                                                <div class="internal-profile-list">

                                                    @foreach($marker->testPanels->sortBy('name') as $panel)

                                                        <div class="internal-profile-row">

                                                            <div>
                                                                <strong>
                                                                    {{ $panel->name }}
                                                                </strong>

                                                                <div class="muted">
                                                                    {{ $panel->slug }}
                                                                    ·
                                                                    {{ $panel->panel_type ?? 'panel' }}
                                                                    @if($panel->thematic_type)
                                                                        · {{ $panel->thematic_type }}
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>

                                                    @endforeach

                                                </div>

                                            </details>

                                        @else

                                            <span class="internal-check internal-check-bad">×</span>
                                            0 panels

                                        @endif
                                    </td>

                                    <td>
                                        @if($panelMarkers->count() === 0)

                                            —

                                        @elseif($missingFrequencyCount === 0)

                                            <span class="internal-check internal-check-ok">✓</span>
                                            complete

                                        @else

                                            <span class="internal-check internal-check-bad">×</span>
                                            missing {{ $missingFrequencyCount }}

                                        @endif
                                    </td>

                                    <td>
                                        @if($panelMarkers->count() === 0)

                                            —

                                        @elseif($roles->count())

                                            {{ $roles->join(', ') }}

                                            @if($panelsWithoutRole > 0)
                                                <span class="status-badge">
                                                    {{ $panelsWithoutRole }} without role
                                                </span>
                                            @endif

                                        @else

                                            <span class="internal-check internal-check-bad">×</span>
                                            no roles

                                        @endif
                                    </td>

                                    <td>
                                        @if($panelCount === 0)

                                            <span class="status-badge">
                                                Not used
                                            </span>

                                        @elseif($missingFrequencyCount > 0 || $panelsWithoutRole > 0)

                                            <span class="status-badge status-warning">
                                                Partial
                                            </span>

                                        @else

                                            <span class="status-badge status-good">
                                                Covered
                                            </span>

                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                    @elseif($layer === 'profiles')

                        <table class="internal-table">

                            <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>Type</th>
                                    <th>Matrix</th>
                                    <th>Applicable</th>
                                    <th>Rules</th>
                                    <th>Missing rules</th>
                                    <th>Coverage</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($profiles as $profile)

                                    <tr>

                                        <td class="internal-marker-cell">
                                            {{ $profile->name }}
                                        </td>

                                        <td>
                                            {{ $profile->profile_type ?? '—' }}
                                        </td>

                                        <td>
                                            {{ $profile->applicability_total }}
                                        </td>

                                        <td>
                                            {{ $profile->applicable_count }}

                                            @if($profile->needs_review_count > 0)
                                                <span class="status-badge status-warning">
                                                    {{ $profile->needs_review_count }} review
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $profile->scoring_rules_count }}
                                        </td>

                                        <td>
                                            @if($profile->missing_rules_count > 0)

                                                <details class="internal-details">

                                                    <summary>
                                                        <span class="internal-check internal-check-bad">×</span>
                                                        {{ $profile->missing_rules_count }}
                                                    </summary>

                                                    <div class="internal-profile-list">

                                                        @foreach($profile->missing_rule_markers->take(40) as $markerName)

                                                            <div class="internal-profile-row">
                                                                <span>{{ $markerName }}</span>
                                                                <span class="status-badge">missing rule</span>
                                                            </div>

                                                        @endforeach

                                                        @if($profile->missing_rule_markers->count() > 40)
                                                            <div class="internal-profile-row">
                                                                <span>
                                                                    +{{ $profile->missing_rule_markers->count() - 40 }} more
                                                                </span>
                                                            </div>
                                                        @endif

                                                    </div>

                                                </details>

                                            @else

                                                <span class="internal-check internal-check-ok">✓</span>
                                                none

                                            @endif
                                        </td>

                                        <td>
                                            @if($profile->coverage_percent !== null)

                                                @if($profile->coverage_percent === 100)
                                                    <span class="internal-check internal-check-ok">✓</span>
                                                @else
                                                    <span class="internal-check internal-check-bad">×</span>
                                                @endif

                                                {{ $profile->coverage_percent }}%

                                            @else
                                                —
                                            @endif
                                        </td>

                                        <td>
                                            @if($profile->applicable_count === 0)

                                                <span class="status-badge">
                                                    Empty profile
                                                </span>

                                            @elseif($profile->coverage_percent === 100)

                                                <span class="status-badge status-good">
                                                    Covered
                                                </span>

                                            @elseif($profile->coverage_percent >= 50)

                                                <span class="status-badge status-warning">
                                                    Partial
                                                </span>

                                            @else

                                                <span class="status-badge">
                                                    Weak
                                                </span>

                                            @endif
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>


                                        
                @elseif($layer === 'readiness')
                                    
                    @php
                        $topWeakMarkers = $markers
                            ->sortBy('readiness_score')
                            ->take(10);
                    @endphp

                    <details class="internal-action-queue">
                        <summary class="internal-action-queue-header">
                            <h2>Top issues</h2>
                            <p>Самые слабые маркеры по readiness и основные причины.</p>
                        </summary>

                        <div class="internal-action-queue-list">
                            @foreach($topWeakMarkers as $marker)
                                <div class="internal-action-queue-item">
                                    <div>
                                        <strong>{{ $marker->name }}</strong>
                                        <span class="muted">{{ $marker->readiness_score }}%</span>
                                    </div>

                                    <div class="internal-action-queue-issues">
                                        @forelse($marker->coverage_issues as $issue)
                                            <span class="status-badge">{{ $issue }}</span>
                                        @empty
                                            <span class="status-badge status-good">No major issues</span>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </details>

                    <div class="internal-controls">

                        <a
                            href="{{ route('internal.controls.markers.index', ['layer' => 'readiness', 'sort' => $sort]) }}"
                            class="internal-control-link {{ empty($status) ? 'is-active' : '' }}"
                        >
                            All
                        </a>

                        <a
                            href="{{ route('internal.controls.markers.index', ['layer' => 'readiness', 'status' => 'weak', 'sort' => $sort]) }}"
                            class="internal-control-link {{ $status === 'weak' ? 'is-active' : '' }}"
                        >
                            Weak
                        </a>

                        <a
                            href="{{ route('internal.controls.markers.index', ['layer' => 'readiness', 'status' => 'partial', 'sort' => $sort]) }}"
                            class="internal-control-link {{ $status === 'partial' ? 'is-active' : '' }}"
                        >
                            Partial
                        </a>

                        <a
                            href="{{ route('internal.controls.markers.index', ['layer' => 'readiness', 'status' => 'strong', 'sort' => $sort]) }}"
                            class="internal-control-link {{ $status === 'strong' ? 'is-active' : '' }}"
                        >
                            Strong
                        </a>

                        <span class="internal-controls-separator"></span>

                        <a
                            href="{{ route('internal.controls.markers.index', ['layer' => 'readiness', 'status' => $status, 'sort' => 'readiness_asc']) }}"
                            class="internal-control-link {{ $sort === 'readiness_asc' ? 'is-active' : '' }}"
                        >
                            Weak first
                        </a>

                        <a
                            href="{{ route('internal.controls.markers.index', ['layer' => 'readiness', 'status' => $status, 'sort' => 'readiness_desc']) }}"
                            class="internal-control-link {{ $sort === 'readiness_desc' ? 'is-active' : '' }}"
                        >
                            Strong first
                        </a>

                    </div>

                    <table class="internal-table">

                        <thead>
                            <tr>
                                <th>Marker</th>
                                <th>Applicability</th>
                                <th>Scoring</th>
                                <th>Ranges</th>
                                <th>Synonyms</th>
                                <th>Content</th>
                                <th>Panels</th>
                                <th>Readiness</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($markers as $marker)

                                @php
                                    $scores = $marker->coverage_scores;

                                    $scoreBadge = function ($score) {
                                        return $score >= 85
                                            ? 'internal-check-ok'
                                            : 'internal-check-bad';
                                    };
                                @endphp

                                <tr>

                                    <td class="internal-marker-cell">
                                        {{ $marker->name }}
                                    </td>

                                    @foreach(['applicability', 'scoring', 'ranges', 'synonyms', 'content', 'panels'] as $scoreKey)
                                        <td>
                                            <span class="internal-check {{ $scoreBadge($scores[$scoreKey]) }}">
                                                {{ $scores[$scoreKey] >= 85 ? '✓' : '×' }}
                                            </span>
                                            {{ $scores[$scoreKey] }}%
                                        </td>
                                    @endforeach

                                    <td>
                                        <strong>{{ $marker->readiness_score }}%</strong>
                                    </td>

                                    <td>
                                        @if($marker->readiness_status === 'strong')

                                            <span class="status-badge status-good">
                                                Strong
                                            </span>

                                        @elseif($marker->readiness_status === 'partial')

                                            <span class="status-badge status-warning">
                                                Partial
                                            </span>

                                        @else

                                            <span class="status-badge">
                                                Weak
                                            </span>

                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>


        @endif

    </div>

</div>

@endsection