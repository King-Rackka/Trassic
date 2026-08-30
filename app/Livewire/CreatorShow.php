<?php

namespace App\Livewire;

use App\Models\CreatorProfile;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreatorShow extends Component
{
    public CreatorProfile $creator;
    public $sort = 'all'; // all | newest | liked

    public function mount(CreatorProfile $creator)
    {
        $this->creator = $creator;
    }

    public function setSort($value)
    {
        $this->sort = $value;
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $existing = Follow::where('user_id', Auth::id())
            ->where('target_type', 'creator')
            ->where('target_id', $this->creator->id)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Follow::create([
                'user_id' => Auth::id(),
                'target_type' => 'creator',
                'target_id' => $this->creator->id,
            ]);
        }
    }

    public function render()
    {
        $works = $this->creator->works()
            ->where('status', 'published')
            ->withCount('appreciations')
            ->when($this->sort === 'newest', fn($q) => $q->orderByDesc('published_at'))
            ->when($this->sort === 'liked', fn($q) => $q->orderByDesc('appreciations_count'))
            ->when($this->sort === 'all', fn($q) => $q->orderByDesc('published_at'))
            ->take(10)
            ->get();

        return view('livewire.creator-show', [
            'works' => $works,
            'isFollowing' => Auth::check() ? $this->creator->isFollowedBy(Auth::id()) : false,
        ]);
    }
}