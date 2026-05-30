<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Marker;
use App\Models\MarkerFaq;

class ImportMarker extends Command
{
    protected $signature = 'import:marker {file}';
    protected $description = 'Import marker from JSON file';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!File::exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $json = File::get($filePath);
        $data = json_decode($json, true);

        if (!$data || !isset($data['marker'])) {
            $this->error("Invalid JSON format");
            return;
        }

        $markerData = $data['marker'];

        $marker = Marker::updateOrCreate(
            ['slug' => $markerData['slug']],
            [
                'code' => $markerData['code'] ?? null,
                'name' => $markerData['name'] ?? null,
                'title' => $markerData['title'] ?? null,
                'h1' => $markerData['h1'] ?? null,
                'seo_title' => $markerData['seo_title'] ?? null,
                'seo_description' => $markerData['seo_description'] ?? null,
                'seo_intro' => $markerData['seo_intro'] ?? null,
                'description' => $markerData['description'] ?? null,
                'what_is' => $markerData['what_is'] ?? null,
                'risks' => $markerData['risks'] ?? null,
                'what_to_do' => $markerData['what_to_do'] ?? null,
                'when_to_test' => $markerData['when_to_test'] ?? null,
                'preparation' => $markerData['preparation'] ?? null,
                'unit' => $markerData['unit'] ?? null,
            ]
        );

        $this->info("Marker saved: " . $marker->slug);

        // FAQ
        if (!empty($data['faq'])) {
            foreach ($data['faq'] as $index => $faq) {
                MarkerFaq::updateOrCreate(
                    [
                        'marker_id' => $marker->id,
                        'question' => $faq['question']
                    ],
                    [
                        'answer' => $faq['answer'],
                        'sort_order' => $index
                    ]
                );
            }

            $this->info("FAQ imported");
        }

        $this->info("Done.");
    }
}