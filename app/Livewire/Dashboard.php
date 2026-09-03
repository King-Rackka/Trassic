<?php

namespace App\Livewire;

use App\Models\Work;
use App\Models\CreatorProfile;
use App\Models\WasteDna;
use App\Models\Appreciation;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $wasteType = '';

    public function setCategory($type)
    {
        $this->wasteType = $this->wasteType === $type ? '' : $type;
    }

    public function toggleLike($workId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $existing = Appreciation::where('user_id', Auth::id())
            ->where('work_id', $workId)
            ->first();

        $existing ? $existing->delete() : Appreciation::create([
            'user_id' => Auth::id(),
            'work_id' => $workId,
        ]);
    }

    public function toggleFollow($creatorId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $existing = Follow::where('user_id', Auth::id())
            ->where('target_type', 'creator')
            ->where('target_id', $creatorId)
            ->first();

        $existing ? $existing->delete() : Follow::create([
            'user_id' => Auth::id(),
            'target_type' => 'creator',
            'target_id' => $creatorId,
        ]);
    }

    public function render()
    {
        $dailyRecommendations = Work::query()
            ->where('status', 'published')
            ->with(['creator', 'wasteDna'])
            ->withCount('appreciations')
            ->when($this->wasteType, function ($q) {
                $q->whereHas('wasteDna', function ($q2) {
                    $q2->where('waste_type', $this->wasteType);
                });
            })
            ->latest('published_at')
            ->take(10)
            ->get();

        $categories = WasteDna::distinct()->pluck('waste_type');

        $topWorksWeekly = Work::query()
            ->where('status', 'published')
            ->withCount(['appreciations as weekly_likes' => function ($q) {
                $q->where('created_at', '>=', now()->subDays(7));
            }])
            ->with(['creator'])
            ->orderByDesc('weekly_likes')
            ->take(3)
            ->get();

        $exploreCreators = CreatorProfile::query()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($creator) {
                $creator->preview_works = $creator->recentWorks(3);
                return $creator;
            });

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

        return view('livewire.dashboard', [
            'categories' => $categories,
            'dailyRecommendations' => $dailyRecommendations,
            'topWorksWeekly' => $topWorksWeekly,
            'exploreCreators' => $exploreCreators,
            'topCreators' => $topCreators,
        ]);
    }
}