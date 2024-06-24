<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VoteController extends Controller
{
    public function store(Request $request, Website $website)
    {
        $userId = Auth::user()->id;
        $websiteId = $website->id;

        if (Vote::where('user_id', $userId)->where('website_id', $websiteId)->exists()) {
            return response()->json(['message' => 'Failed'], 403);
        }
        Vote::create([
            'user_id' => $userId,
            'website_id' => $websiteId,
        ]);
        return response()->json(['message' => 'Success']);
    }

    public function delete(Request $request, Website $website)
    {
        $vote = Vote::where('website_id', $website->id)->where('user_id', Auth::user()->id)->first();

        $vote->delete();

        return response()->json(['message' => 'Success']);
    }
}
