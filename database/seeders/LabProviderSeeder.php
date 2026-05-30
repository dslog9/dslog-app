<?php

namespace Database\Seeders;

use App\Models\LabProvider;
use Illuminate\Database\Seeder;

class LabProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            [
                'slug' => 'invitro',
                'name' => 'Инвитро',
                'search_url_pattern' => 'https://www.invitro.ru/search/?q={query}',
            ],
            [
                'slug' => 'gemotest',
                'name' => 'Гемотест',
                'search_url_pattern' => 'https://gemotest.ru/search/?q={query}',
            ],
            [
                'slug' => 'helix',
                'name' => 'Хеликс',
                'search_url_pattern' => 'https://helix.ru/search?q={query}',
            ],
            [
                'slug' => 'kdl',
                'name' => 'KDL',
                'search_url_pattern' => 'https://kdl.ru/search?query={query}',
            ],
            [
                'slug' => 'cmd',
                'name' => 'CMD',
                'search_url_pattern' => 'https://www.cmd-online.ru/search/?q={query}',
            ],
        ];

        foreach ($providers as $provider) {
            LabProvider::updateOrCreate(
                ['slug' => $provider['slug']],
                [
                    'name' => $provider['name'],
                    'search_url_pattern' => $provider['search_url_pattern'],
                    'country' => 'ru',
                    'is_active' => true,
                ]
            );
        }
    }
}