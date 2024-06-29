<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminDeleteWebsiteController extends Controller
{

    public function delete(Request $request, Website $website)
    {
        Gate::authorize('delete', User::class);
        $website->delete();
        return response()->json(['message' => "Success"]);
    }

    // public function deleteMany(Request $request)
    // {
    //     Gate::authorize(User::class);
    //     return response()->json(['message' => "Success"]);
    // }
}
