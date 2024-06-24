<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WebsiteController extends Controller
{
    public function index(Request $request)
    {
        $page_size = $request->query('size') ?? 20;

        $websites = Website::select('websites.id', 'websites.name', 'websites.url')
            ->with(['categories' => function ($query) {
                $query->select('categories.id', 'categories.name');
            }])
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->paginate($page_size);

        return response()->json(['websites' => $websites]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
        ]);

        $website = Website::create($validated);

        return response()->json(['message' => "Success", 'data' => $website]);
    }

    public function search(Request $request)
    {
        $page_size = $request->query('size') ?? 20;

        $validated = $request->validate([
            'q' => 'required|string|max:255',
            'categories' => 'array',
            'categories.*' => 'integer|exists:categories,id',
        ]);

        $query = $validated['q'];
        $categoryIds = $validated['categories'] ?? [];


        $websites = Website::query()
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('url', 'LIKE', "%{$query}%")
            ->when($categoryIds, function ($q) use ($categoryIds) {
                $q->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            })
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->paginate($page_size);

        return response()->json(['message' => "Success", 'websites' => $websites]);
    }
}
