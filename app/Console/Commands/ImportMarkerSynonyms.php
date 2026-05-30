<?php

namespace App\Console\Commands;

use App\Models\Marker;
use App\Models\MarkerSynonym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportMarkerSynonyms extends Command
{
    protected $signature = 'import:marker-synonyms {file}';

    protected $description = 'Import marker synonyms from JSON';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!File::exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return self::FAILURE;
        }

        $json = File::get($filePath);

        $data = json_decode($json, true);

        if (
            !$data ||
            !isset($data['synonyms']) ||
            !is_array($data['synonyms'])
        ) {
            $this->error('Invalid JSON format');
            return self::FAILURE;
        }

        $total = 0;

        foreach ($data['synonyms'] as $item) {

            $slug = $item['marker'] ?? null;

            if (!$slug) {
                $this->warn('Skipped item without marker slug');
                continue;
            }

            $marker = Marker::where('slug', $slug)->first();

            if (!$marker) {
                $this->warn("Marker not found: {$slug}");
                continue;
            }

            $synonyms = $item['synonyms'] ?? [];

            if (!is_array($synonyms)) {
                continue;
            }

            MarkerSynonym::where('marker_id', $marker->id)->delete();

            foreach ($synonyms as $synonym) {

                $synonym = trim($synonym);

                if (!$synonym) {
                    continue;
                }

                MarkerSynonym::create([
                    'marker_id' => $marker->id,
                    'name' => $synonym,
                ]);

                $total++;
            }

            $this->info("Imported synonyms: {$slug}");
        }

        $this->info("Done. Total synonyms: {$total}");

        return self::SUCCESS;
    }
}