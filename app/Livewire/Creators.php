<?php

namespace App\Livewire;

use App\Models\CreatorProfile;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\HasInteractions;
use Livewire\Component;

class Creators extends Component
{
    use HasInteractions;

    public function render()
    {
        $topCreators = CreatorProfile::query()
            ->withCount(['works as published_works_count' => function ($q) {
                $q->where('status', 'published');
            }])
            ->orderByDesc('published_works_count')
            ->take(3)
            ->get()
            ->map(function ($creator) {
                $creator->preview_works = $creator->recentWorks(4);
                return $creator;
            });

        $creators = CreatorProfile::query()
            ->withCount(['works as published_works_count' => function ($q) {
                $q->where('status', 'published');
            }])
            ->orderByDesc('published_works_count')
            ->take(5)
            ->get()
            ->map(function ($creator) {
                $creator->preview_works = $creator->recentWorks(3);
                return $creator;
            });

        return view('livewire.creators', [
            'topCreators' => $topCreators,
            'creators' => $creators,
        ]);
    }
}