<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');

        $markers = Marker::query()
            ->with('group')
            ->where('is_active', true)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'ilike', "%{$query}%")
                        ->orWhere('slug', 'ilike', "%{$query}%")
                        ->orWhere('code', 'ilike', "%{$query}%");
                });
            })
            ->orderBy('name')
            ->limit(30)
            ->get();

        return view('search.index', [
            'query' => $query,
            'markers' => $markers,
        ]);
    }
}