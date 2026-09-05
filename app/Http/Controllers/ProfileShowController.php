<?php

namespace App\Http\Controllers;

use App\Models\CreatorProfile;
use App\Models\Work;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileShowController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $creator = CreatorProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'slug' => \Illuminate\Support\Str::slug($user->name . '-' . $user->id),
            ]
        );

        $works = Work::where('creator_id', $creator->id)
            ->withCount('appreciations')
            ->latest()
            ->paginate(10);

        $postsCount = Work::where('creator_id', $creator->id)->count();
        $followersCount = Follow::where('target_type', 'creator')->where('target_id', $creator->id)->count();
        $followingCount = Follow::where('user_id', $user->id)->count();

        return view('profile.show', [
            'creator' => $creator,
            'user' => $user,
            'works' => $works,
            'postsCount' => $postsCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'activeFilter' => 'diposting',
        ]);
    }
}