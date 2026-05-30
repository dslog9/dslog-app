<?php

namespace App\Http\Controllers;

use App\Models\LabProvider;
use App\Models\Marker;
use App\Models\MarkerGroup;

class MarkerController extends Controller
{
    public function index()
    {
        $view = request('view', 'groups');

        if (!in_array($view, ['groups', 'list', 'az'], true)) {
            $view = 'groups';
        }

        $groups = MarkerGroup::query()
            ->withCount(['markers' => function ($query) {
                $query->where('is_active', true);
            }])
            ->with(['markers' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $markers = Marker::query()
            ->with('group')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('markers.index', [
            'view' => $view,
            'groups' => $groups,
            'markers' => $markers,
        ]);
    }

    public function az()
    {
        return redirect()->route('markers.index', ['view' => 'az']);
    }


    public function group(string $groupSlug)
    {
        $group = MarkerGroup::query()
            ->with(['markers' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('name');
            }])
            ->where('slug', $groupSlug)
            ->first();

        if (!$group) {
            abort(404);
        }

        return view('markers.group', [
            'group' => $group,
        ]);
    }


    public function show(string $slug)
    {
        $marker = Marker::with([
                'faqs',
                'group',
                'relations.relatedMarker',
            ])
            ->where('slug', $slug)
            ->first();

        if (!$marker) {
            abort(404);
        }

        $labProviders = LabProvider::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('markers.show', [
            'marker' => $marker,
            'labProviders' => $labProviders,
        ]);
    }
}