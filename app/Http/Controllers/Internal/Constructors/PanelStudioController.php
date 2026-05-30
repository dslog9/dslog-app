<?php

namespace App\Http\Controllers\Internal\Constructors;

use App\Http\Controllers\Controller;
use App\Models\TestPanel;
use App\Models\TestPanelSection;


class PanelStudioController extends Controller
{
    public function index()
    {
        $panels = TestPanel::query()
            ->withCount([
                'sections',
                'panelMarkers',
                'contentBlocks',
                'faqs',
                'relatedPanels',
            ])
            ->orderBy('panel_type')
            ->orderBy('category')
            ->orderBy('age_min')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('internal.panels.index', [
            'panels' => $panels,
        ]);
    }

    public function show(TestPanel $panel)
    {
        $panel->load([
            'sections.panelMarkers.marker',
            'panelMarkers.marker',
            'contentBlocks',
            'faqs',
            'relatedPanels',
        ]);

        $sectionStatuses = $panel->sections->map(function ($section) {
            $markersCount = $section->panelMarkers->count();

            $missingPriorityCount = $section->panelMarkers
                ->whereNull('priority')
                ->count();

            $missingFrequencyCount = $section->panelMarkers
                ->whereNull('frequency_months')
                ->count();

            $missingReasonCount = $section->panelMarkers
                ->filter(fn ($item) => blank($item->reason))
                ->count();

            if ($markersCount === 0) {
                return 'incomplete';
            }

            if (
                $missingPriorityCount === 0
                && $missingFrequencyCount === 0
                && $missingReasonCount === 0
            ) {
                return 'complete';
            }

            return 'partial';
        });

        $completeSectionsCount = $sectionStatuses
            ->filter(fn ($status) => $status === 'complete')
            ->count();

        $partialSectionsCount = $sectionStatuses
            ->filter(fn ($status) => $status === 'partial')
            ->count();

        $incompleteSectionsCount = $sectionStatuses
            ->filter(fn ($status) => $status === 'incomplete')
            ->count();

        $totalSectionsCount = $panel->sections->count();

        $panelReadinessScore = $totalSectionsCount > 0
            ? (int) round(($completeSectionsCount / $totalSectionsCount) * 100)
            : 0;

        if ($totalSectionsCount === 0) {
            $panelReadinessStatus = 'incomplete';
        } elseif ($panelReadinessScore === 100) {
            $panelReadinessStatus = 'complete';
        } elseif ($panelReadinessScore > 0) {
            $panelReadinessStatus = 'partial';
        } else {
            $panelReadinessStatus = 'incomplete';
        }
        return view('internal.panels.show', [
            'panel' => $panel,
            'completeSectionsCount' => $completeSectionsCount,
            'partialSectionsCount' => $partialSectionsCount,
            'incompleteSectionsCount' => $incompleteSectionsCount,
            'panelReadinessScore' => $panelReadinessScore,
            'panelReadinessStatus' => $panelReadinessStatus,
        ]);
    }

    public function section(TestPanel $panel, TestPanelSection $section)
    {
        $section->load([
            'panelMarkers.marker',
        ]);

        $missingPriorityCount = $section->panelMarkers
            ->whereNull('priority')
            ->count();

        $missingFrequencyCount = $section->panelMarkers
            ->whereNull('frequency_months')
            ->count();

        $missingReasonCount = $section->panelMarkers
            ->filter(fn ($item) => blank($item->reason))
            ->count();

        $requiredMarkersCount = $section->panelMarkers
            ->where('is_required', true)
            ->count();

        if ($section->panelMarkers->count() === 0) {
            $sectionStatus = 'incomplete';
        } elseif (
            $missingPriorityCount === 0
            && $missingFrequencyCount === 0
            && $missingReasonCount === 0
        ) {
            $sectionStatus = 'complete';
        } else {
            $sectionStatus = 'partial';
        }

        $totalMarkersCount = $section->panelMarkers->count();

        $priorityReadyCount = $totalMarkersCount - $missingPriorityCount;
        $frequencyReadyCount = $totalMarkersCount - $missingFrequencyCount;
        $reasonReadyCount = $totalMarkersCount - $missingReasonCount;

        // is_required считается заполненным, если поле не null
        $missingRequiredCount = $section->panelMarkers
            ->filter(fn ($item) => is_null($item->is_required))
            ->count();

        $requiredReadyCount = $totalMarkersCount - $missingRequiredCount;

        $sectionReadinessScore = $totalMarkersCount > 0
            ? (int) round((
                ($priorityReadyCount / $totalMarkersCount) * 25
                + ($frequencyReadyCount / $totalMarkersCount) * 25
                + ($requiredReadyCount / $totalMarkersCount) * 25
                + ($reasonReadyCount / $totalMarkersCount) * 25
            ))
            : 0;

        if ($sectionReadinessScore >= 90) {
            $sectionStatus = 'complete';
        } elseif ($sectionReadinessScore > 0) {
            $sectionStatus = 'partial';
        } else {
            $sectionStatus = 'incomplete';
        }
        return view('internal.panels.section', [
            'panel' => $panel,
            'section' => $section,
            'missingPriorityCount' => $missingPriorityCount,
            'missingFrequencyCount' => $missingFrequencyCount,
            'missingReasonCount' => $missingReasonCount,
            'requiredMarkersCount' => $requiredMarkersCount,
            'sectionStatus' => $sectionStatus,
            'sectionReadinessScore' => $sectionReadinessScore,
            'missingRequiredCount' => $missingRequiredCount,
        ]);
    }



}

