<?php

namespace App\Livewire;

use App\Models\CreatorProfile;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowButton extends Component
{
    public CreatorProfile $creator;
    public bool $isFollowing = false;

    public function mount(CreatorProfile $creator)
    {
        $this->creator = $creator;
        $this->isFollowing = Auth::check() ? $creator->isFollowedBy(Auth::id()) : false;
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
            $this->isFollowing = false;
        } else {
            Follow::create([
                'user_id' => Auth::id(),
                'target_type' => 'creator',
                'target_id' => $this->creator->id,
            ]);
            $this->isFollowing = true;
        }
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}