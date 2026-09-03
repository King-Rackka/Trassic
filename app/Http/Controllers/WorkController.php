<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    public function show(Work $work)
    {
        $work->load(['creator', 'wasteDna', 'images']);

        $creatorWorks = $work->creator->works()
            ->where('status', 'published')
            ->where('id', '!=', $work->id)
            ->withCount('appreciations')
            ->with('wasteDna')
            ->orderByDesc('published_at')
            ->take(10)
            ->get();

        $similarWorks = $work->similarWorks(4);

        return view('work-show', [
            'work' => $work,
            'creatorWorks' => $creatorWorks,
            'similarWorks' => $similarWorks,
            'isBookmarked' => Auth::check() ? $work->isBookmarkedBy(Auth::id()) : false,
            'appreciationsCount' => $work->appreciations()->count(),
        ]);
    }
}