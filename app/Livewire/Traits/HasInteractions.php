<?php

namespace App\Livewire\Traits;

use App\Models\Follow;
use App\Models\Appreciation;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin \Livewire\Component
 */
trait HasInteractions
{
    // Toggle Follow Kreator
    public function toggleFollow(int $creatorId): void
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $existing = Follow::where('user_id', Auth::id())
            ->where('target_type', 'creator')
            ->where('target_id', $creatorId)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Follow::create([
                'user_id' => Auth::id(),
                'target_type' => 'creator',
                'target_id' => $creatorId,
            ]);
        }
    }

    // Toggle Appreciate / Like Karya
    public function toggleAppreciate(int $workId): void
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
}