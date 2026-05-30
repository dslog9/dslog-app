<?php

namespace App\Console\Commands;

use App\Models\Marker;
use App\Models\MarkerFaq;
use App\Models\MarkerGroup;
use App\Models\MarkerRelation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportMarkers extends Command
{
    protected $signature = 'import:markers {path}';

    protected $description = 'Import split marker JSON files';

    public function handle()
    {
        $basePath = rtrim($this->argument('path'), '/');

        /*
        |--------------------------------------------------------------------------
        | Load files
        |--------------------------------------------------------------------------
        */

        $core = $this->loadJson($basePath . '/markers_core.json');
        $norms = $this->loadJson($basePath . '/markers_norms.json');
        $clinical = $this->loadJson($basePath . '/markers_clinical_blocks.json');
        $pageBlocks = $this->loadJson($basePath . '/markers_page_blocks.json');
        $faqs = $this->loadJson($basePath . '/markers_faqs.json');
        $relations = $this->loadJson($basePath . '/markers_relations.json');

        if (!$core) {
            return self::FAILURE;
        }

        /*
        |--------------------------------------------------------------------------
        | PASS 1 — CORE MARKERS
        |--------------------------------------------------------------------------
        */

        foreach ($core['markers'] as $markerData) {

            if (empty($markerData['slug'])) {
                $this->warn('Skipped marker without slug');
                continue;
            }

            $groupId = null;

            if (
                !empty($markerData['group_slug']) &&
                !empty($markerData['group_name'])
            ) {
                $group = MarkerGroup::updateOrCreate(
                    ['slug' => $markerData['group_slug']],
                    ['name' => $markerData['group_name']]
                );

                $groupId = $group->id;
            }

            Marker::updateOrCreate(
                ['slug' => $markerData['slug']],
                [
                    'code' => $markerData['code'] ?? null,
                    'name' => $markerData['name'] ?? null,

                    'group_id' => $groupId,

                    'title' => $markerData['title'] ?? null,
                    'h1' => $markerData['h1'] ?? null,

                    'description' => $markerData['description'] ?? null,

                    'seo_title' => $markerData['seo_title'] ?? null,
                    'seo_description' => $markerData['seo_description'] ?? null,
                    'seo_intro' => $markerData['seo_intro'] ?? null,

                    'short' => $markerData['short'] ?? null,
                    'what_is' => $markerData['what_is'] ?? null,

                    'unit' => $markerData['unit'] ?? null,

                    'is_active' => $markerData['is_active'] ?? true,
                ]
            );

            $this->info('Saved core: ' . $markerData['slug']);
        }

        /*
        |--------------------------------------------------------------------------
        | PASS 2 — NORMS
        |--------------------------------------------------------------------------
        */

        if (!empty($norms['norms'])) {

            foreach ($norms['norms'] as $item) {

                $marker = Marker::where('slug', $item['marker'])->first();

                if (!$marker) {
                    $this->warn('Marker not found for norms: ' . $item['marker']);
                    continue;
                }

                $marker->update([
                    'norms' => json_encode(
                        $item['norms'],
                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    ),
                ]);

                $this->line('Norms: ' . $marker->slug);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PASS 3 — CLINICAL BLOCKS
        |--------------------------------------------------------------------------
        */

        if (!empty($clinical['clinical_blocks'])) {

            foreach ($clinical['clinical_blocks'] as $item) {

                $marker = Marker::where('slug', $item['marker'])->first();

                if (!$marker) {
                    $this->warn('Marker not found for clinical: ' . $item['marker']);
                    continue;
                }

                $marker->update([
                    'interpretation' => $this->jsonOrNull($item['interpretation'] ?? null),
                    'low' => $this->jsonOrNull($item['low'] ?? null),
                    'high' => $this->jsonOrNull($item['high'] ?? null),

                    'risks' => $this->jsonOrNull($item['risks'] ?? null),

                    'what_to_do' => $this->jsonOrNull($item['what_to_do'] ?? null),

                    'when_to_test' => $this->jsonOrNull($item['when_to_test'] ?? null),

                    'preparation' => $this->jsonOrNull($item['preparation'] ?? null),
                ]);

                $this->line('Clinical: ' . $marker->slug);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PASS 4 — PAGE BLOCKS
        |--------------------------------------------------------------------------
        */

        if (!empty($pageBlocks['page_blocks'])) {

            foreach ($pageBlocks['page_blocks'] as $item) {

                $marker = Marker::where('slug', $item['marker'])->first();

                if (!$marker) {
                    $this->warn('Marker not found for page blocks: ' . $item['marker']);
                    continue;
                }

                $marker->update([
                    'page_blocks' => $this->jsonOrNull($item['page_blocks'] ?? null),
                ]);

                $this->line('Page blocks: ' . $marker->slug);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PASS 5 — FAQ
        |--------------------------------------------------------------------------
        */

        if (!empty($faqs['faqs'])) {

            foreach ($faqs['faqs'] as $item) {

                $marker = Marker::where('slug', $item['marker'])->first();

                if (!$marker) {
                    $this->warn('Marker not found for FAQ: ' . $item['marker']);
                    continue;
                }

                MarkerFaq::where('marker_id', $marker->id)->delete();

                foreach (($item['faqs'] ?? []) as $index => $faq) {

                    if (
                        empty($faq['question']) ||
                        empty($faq['answer'])
                    ) {
                        continue;
                    }

                    MarkerFaq::create([
                        'marker_id' => $marker->id,
                        'question' => $faq['question'],
                        'answer' => $faq['answer'],
                        'sort_order' => $index + 1,
                    ]);
                }

                $this->line('FAQ: ' . $marker->slug);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PASS 6 — RELATIONS
        |--------------------------------------------------------------------------
        */

        if (!empty($relations['relations'])) {

            foreach ($relations['relations'] as $item) {

                $marker = Marker::where('slug', $item['marker'])->first();

                if (!$marker) {
                    $this->warn('Marker not found for relations: ' . $item['marker']);
                    continue;
                }

                MarkerRelation::where('marker_id', $marker->id)->delete();

                foreach (($item['related'] ?? []) as $index => $relatedSlug) {

                    $related = Marker::where('slug', $relatedSlug)->first();

                    if (!$related) {
                        $this->warn("Related not found: {$item['marker']} → {$relatedSlug}");
                        continue;
                    }

                    if ($related->id === $marker->id) {
                        continue;
                    }

                    MarkerRelation::updateOrCreate(
                        [
                            'marker_id' => $marker->id,
                            'related_marker_id' => $related->id,
                            'relation_type' => 'related',
                        ],
                        [
                            'priority' => $index + 1,
                        ]
                    );
                }

                $this->line('Relations: ' . $marker->slug);
            }
        }

        $this->info('Import completed.');

        return self::SUCCESS;
    }

    private function loadJson($path): ?array
    {
        if (!File::exists($path)) {
            $this->warn('File missing: ' . $path);
            return null;
        }

        return json_decode(File::get($path), true);
    }

    private function jsonOrNull($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            return json_encode(
                $value,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        return $value;
    }
}