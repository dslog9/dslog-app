<?php

namespace App\Console\Commands;

use App\Models\Marker;
use App\Models\TestPanel;
use App\Models\TestPanelMarker;
use App\Models\TestPanelSection;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportTestPanels extends Command
{
protected $signature = 'import:test-panels';

    protected $description = 'Import test panels from JSON file';

    public function handle()
    {
        $panelsPath = database_path('content/panels/test_panels.json');
        $sectionsPath = database_path('content/panels/test_panel_sections.json');
        $markersPath = database_path('content/panels/test_panel_markers.json');

        foreach ([$panelsPath, $sectionsPath, $markersPath] as $path) {
            if (!File::exists($path)) {
                $this->error("File not found: {$path}");
                return self::FAILURE;
            }
        }

        $panelsData = json_decode(File::get($panelsPath), true);
        $sectionsData = json_decode(File::get($sectionsPath), true);
        $markersData = json_decode(File::get($markersPath), true);

        if (
            !$panelsData ||
            empty($panelsData['panels']) ||
            !is_array($panelsData['panels'])
        ) {
            $this->error('Invalid test_panels.json');
            return self::FAILURE;
        }

        foreach ($panelsData['panels'] as $panelData) {

            $panel = TestPanel::updateOrCreate(
                ['slug' => $panelData['slug']],
                [
                    'name' => $panelData['name'],
                    'seo_title' => $panelData['seo_title'] ?? null,
                    'seo_description' => $panelData['seo_description'] ?? null,
                    'description' => $panelData['description'] ?? null,
                    'category' => $panelData['category'] ?? null,
                    'gender' => $panelData['gender'] ?? null,
                    'age_min' => $panelData['age_min'] ?? null,
                    'age_max' => $panelData['age_max'] ?? null,
                    'short_description' => $panelData['short_description'] ?? null,
                    'cover_image' => $panelData['cover_image'] ?? null,
                    'sort_order' => $panelData['sort_order'] ?? 100,
                    'is_active' => $panelData['is_active'] ?? true,
                    'panel_type' => $panelData['panel_type'] ?? 'checkup',
                    'thematic_type' => $panelData['thematic_type'] ?? null,
                ]
            );

            $this->info('Saved panel: ' . $panel->slug);

            TestPanelMarker::where('test_panel_id', $panel->id)->delete();
            TestPanelSection::where('test_panel_id', $panel->id)->delete();

            $panelSections = collect($sectionsData['sections'] ?? [])
                ->where('panel_slug', $panel->slug)
                ->sortBy('priority');

            foreach ($panelSections as $sectionData) {

                $section = TestPanelSection::create([
                    'test_panel_id' => $panel->id,
                    'slug' => $sectionData['slug'],
                    'name' => $sectionData['name'],
                    'description' => $sectionData['description'] ?? null,
                    'priority' => $sectionData['priority'] ?? 100,
                    'frequency_months' => $sectionData['frequency_months'] ?? null,
                    'is_required' => $sectionData['is_required'] ?? true,
                ]);

                $sectionMarkers = collect($markersData['markers'] ?? [])
                    ->where('panel_slug', $panel->slug)
                    ->where('section_slug', $section->slug)
                    ->sortBy('priority')
                    ->values();

                foreach ($sectionMarkers as $index => $markerItem) {

                    $this->createPanelMarker(
                        panel: $panel,
                        markerItem: $markerItem,
                        index: $index,
                        section: $section,
                        sectionRole: $markerItem['role'] ?? 'core'
                    );
                }

                $this->line('  Section: ' . $section->slug);
            }
        }

        $this->info('Import completed.');

        return self::SUCCESS;
    }

    private function createPanelMarker(
        TestPanel $panel,
        array|string $markerItem,
        int $index,
        ?TestPanelSection $section = null,
        string $sectionRole = 'core'
    ): void {
        if (is_string($markerItem)) {
            $markerSlug = $markerItem;
            $markerData = [];
        } else {
            $markerSlug = $markerItem['marker'] ?? $markerItem['slug'] ?? null;
            $markerData = $markerItem;
        }

        if (!$markerSlug) {
            $this->warn("  Skipped marker without slug in panel {$panel->slug}");
            return;
        }

        $marker = Marker::where('slug', $markerSlug)
            ->orWhere('code', $markerSlug)
            ->first();

        if (!$marker) {
            $this->warn("  Marker not found: {$panel->slug} → {$markerSlug}");
            return;
        }

        TestPanelMarker::create([
            'test_panel_id' => $panel->id,
            'test_panel_section_id' => $section?->id,
            'marker_id' => $marker->id,
            'priority' => $markerData['priority'] ?? ($index + 1),
            'frequency_months' => $markerData['frequency_months'] ?? $section?->frequency_months,
            'age_min' => $markerData['age_min'] ?? null,
            'age_max' => $markerData['age_max'] ?? null,
            'gender' => $markerData['gender'] ?? null,
            'is_required' => $markerData['is_required'] ?? $section?->is_required ?? true,
            'role' => $markerData['role'] ?? $sectionRole,
            'reason' => $markerData['reason'] ?? null,
            'note' => $markerData['note'] ?? null,
        ]);
    }

    private function findDuplicateMarkersInPanel(array $panelData): array
    {
        $markers = [];

        foreach (($panelData['sections'] ?? []) as $sectionData) {
            foreach (($sectionData['markers'] ?? []) as $markerItem) {
                $markerSlug = is_string($markerItem)
                    ? $markerItem
                    : ($markerItem['marker'] ?? $markerItem['slug'] ?? null);

                if ($markerSlug) {
                    $markers[] = $markerSlug;
                }
            }
        }

        foreach (($panelData['markers'] ?? []) as $markerItem) {
            $markerSlug = is_string($markerItem)
                ? $markerItem
                : ($markerItem['marker'] ?? $markerItem['slug'] ?? null);

            if ($markerSlug) {
                $markers[] = $markerSlug;
            }
        }

        return array_values(array_unique(array_filter(array_keys(array_count_values($markers), 2))));
    }
}