<?php

namespace App\Livewire;

use App\Models\CreatorProfile;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CreatorsMore extends Component
{
    use WithPagination;

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

    public function render()
    {
        $creators = CreatorProfile::query()
            ->withCount(['works as published_works_count' => function ($q) {
                $q->where('status', 'published');
            }])
            ->orderByDesc('published_works_count')
            ->paginate(12)
            ->through(function ($creator) {
                $creator->preview_works = $creator->recentWorks(3);
                return $creator;
            });

        return view('livewire.creators-more', [
            'creators' => $creators,
        ]);
    }
}