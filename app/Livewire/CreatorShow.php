<?php

namespace App\Livewire;

use App\Models\CreatorProfile;
use App\Models\Follow;
use App\Models\Work;
use App\Models\Appreciation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreatorShow extends Component
{
    public CreatorProfile $creator;
    public string $sort = 'all';

    public function mount(CreatorProfile $creator): void
    {
        $this->creator = $creator;
    }

    public function setSort(string $value): void
    {
        if (in_array($value, ['all', 'newest', 'liked'])) {
            $this->sort = $value;
        }
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

        if ($existing) {
            $existing->delete();
        } else {
            Appreciation::create([
                'user_id' => Auth::id(),
                'work_id' => $workId,
            ]);
        }
    }

    public function toggleFollow(): void
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $userId = Auth::id();

        $deleted = Follow::where('user_id', $userId)
            ->where('target_type', 'creator') 
            ->where('target_id', $this->creator->id)
            ->delete();

        if (!$deleted) {
            Follow::create([
                'user_id'     => $userId,
                'target_type' => 'creator',
                'target_id'   => $this->creator->id,
            ]);
        }
    }

    public function render()
    {
        $works = $this->creator->works()
            ->where('status', 'published')
            ->withCount('appreciations')
            ->when($this->sort === 'liked', function ($q) {
                $q->orderByDesc('appreciations_count');
            }, function ($q) {
                $q->latest('published_at');
            })
            ->take(10)
            ->get();

        return view('livewire.creator-show', [
            'works'       => $works,
            'isFollowing' => Auth::check() ? $this->creator->isFollowedBy(Auth::id()) : false,
        ]);
    }
}