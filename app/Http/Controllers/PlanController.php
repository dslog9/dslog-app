<?php

namespace App\Http\Controllers;

use App\Models\TestPanel;
use App\Services\ChecklistService;

class PlanController extends Controller
{
public function index()
{
    $selectedTab = request('tab', 'checkups');
    $selectedCategory = request('category');
    $selectedAgeRange = request('age_range');
    $selectedThematicType = request('thematic_type');

    $plans = TestPanel::query()
        ->withCount('markers')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

    $checkupPlans = $plans
        ->where('panel_type', 'checkup');

    if ($selectedCategory && $selectedTab === 'checkups') {
        $checkupPlans = $checkupPlans
            ->where('category', $selectedCategory);
    }

    if ($selectedAgeRange && $selectedTab === 'checkups') {
        [$ageMin, $ageMax] = array_pad(explode('-', $selectedAgeRange), 2, null);

        $ageMin = $ageMin !== null ? (int) $ageMin : null;
        $ageMax = $ageMax !== null && $ageMax !== '' ? (int) $ageMax : null;

        $checkupPlans = $checkupPlans->filter(function ($plan) use ($ageMin, $ageMax) {
            return (int) $plan->age_min === $ageMin
                && (
                    ($ageMax === null && $plan->age_max === null)
                    || ((int) $plan->age_max === $ageMax)
                );
        });
    }

    $thematicPlans = $plans
        ->where('panel_type', 'thematic');

    if ($selectedThematicType && $selectedTab === 'thematic') {
        $thematicPlans = $thematicPlans
            ->where('thematic_type', $selectedThematicType);
    }

    $checkupCategories = TestPanel::query()
        ->where('is_active', true)
        ->where('panel_type', 'checkup')
        ->whereNotNull('category')
        ->select('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category');

    $ageRanges = TestPanel::query()
        ->where('is_active', true)
        ->where('panel_type', 'checkup')
        ->when($selectedCategory, fn ($query) => $query->where('category', $selectedCategory))
        ->whereNotNull('age_min')
        ->get(['age_min', 'age_max'])
        ->map(function ($panel) {
            return [
                'key' => $panel->age_min . '-' . ($panel->age_max ?? ''),
                'label' => $panel->age_max
                    ? $panel->age_min . '–' . $panel->age_max
                    : $panel->age_min . '+',
                'age_min' => $panel->age_min,
            ];
        })
        ->unique('key')
        ->sortBy('age_min')
        ->values();

    $thematicTypes = TestPanel::query()
        ->where('is_active', true)
        ->where('panel_type', 'thematic')
        ->whereNotNull('thematic_type')
        ->select('thematic_type')
        ->distinct()
        ->orderBy('thematic_type')
        ->pluck('thematic_type');

    return view('plans.index', [
        'plans' => $plans,
        'checkupPlans' => $checkupPlans,
        'thematicPlans' => $thematicPlans,

        'checkupCategories' => $checkupCategories,
        'ageRanges' => $ageRanges,
        'thematicTypes' => $thematicTypes,

        'selectedTab' => $selectedTab,
        'selectedCategory' => $selectedCategory,
        'selectedAgeRange' => $selectedAgeRange,
        'selectedThematicType' => $selectedThematicType,
    ]);
}

    public function show(string $slug)
    {
        $plan = TestPanel::query()
            ->with([
                'sections.panelMarkers.marker.group',
                'panelMarkers.marker.group',

                'contentBlocks.items',
                'relatedPanels.relatedPanel',
                'faqs',
            ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('plans.show', [
            'plan' => $plan,
        ]);
    }

    public function addToMyPlan(string $slug, ChecklistService $checklistService)
    {
        $panel = TestPanel::where('slug', $slug)->firstOrFail();

        $userId = 1; // MVP до auth

        $checklistService->createFromPanel($panel, $userId);

        return redirect('/my-checklist');
    }
}