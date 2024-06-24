<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class WebsiteCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('websites')
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->get();

        return response()->json(['categories_websites' => $categories]);
    }

    public function show(Request $request, Category $category)
    {
        $page_size = $request->query('size') ?? 20;
        $websites = $category->websites()->select('websites.id', 'websites.name', 'websites.url')
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->paginate($page_size);

        return response()->json(['id' => $category->id, 'name' => $category->name, 'websites' => $websites]);
    }
}
