<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use App\Models\MarkerGroup;
use App\Models\TestPanel;

class SitemapController extends Controller
{
    public function index()
    {
        $staticUrls = [
            url('/'),
            url('/markers'),
            url('/markers/az'),
            url('/plans'),
            url('/analyze-ui'),
            url('/my-checklist'),
        ];

        $groups = MarkerGroup::query()
            ->whereNotNull('slug')
            ->orderBy('slug')
            ->get();

        $markers = Marker::query()
            ->whereNotNull('slug')
            ->where('is_active', true)
            ->orderBy('slug')
            ->get();

        $plans = TestPanel::query()
            ->whereNotNull('slug')
            ->orderBy('slug')
            ->get();

        $xml = view('sitemap', [
            'staticUrls' => $staticUrls,
            'groups' => $groups,
            'markers' => $markers,
            'plans' => $plans,
        ]);

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}