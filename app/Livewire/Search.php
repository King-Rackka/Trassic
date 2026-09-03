<?php

namespace App\Livewire;

use App\Models\Work;
use App\Models\CreatorProfile;
use App\Models\Appreciation;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Search extends Component
{
    public $query = '';
    public $worksLimit = 10;
    public $creatorsLimit = 5;

    public function mount()
    {
        $this->query = request('q', '');
    }

    public function updatedQuery()
    {
        $this->worksLimit = 10;
        $this->creatorsLimit = 5;
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

    public function loadMoreWorks()
    {
        $this->worksLimit += 10;
    }

    public function loadMoreCreators()
    {
        $this->creatorsLimit += 5;
    }

    public function render()
    {
        $works = collect();
        $creators = collect();

        $totalWorks = 0;
        $totalCreators = 0;

        if (strlen($this->query) >= 2) {
            $totalWorks = Work::where('title', 'LIKE', '%' . $this->query . '%')
                ->orWhere('description', 'LIKE', '%' . $this->query . '%')
                ->count();

            $works = Work::with(['creator', 'wasteDna'])
                ->where('title', 'LIKE', '%' . $this->query . '%')
                ->orWhere('description', 'LIKE', '%' . $this->query . '%')
                ->latest()
                ->take($this->worksLimit)
                ->get();

            $totalCreators = CreatorProfile::where('name', 'LIKE', '%' . $this->query . '%')->count();

            $creators = CreatorProfile::with(['works' => function($q) {
                    $q->latest()->take(3);
                }])
                ->where('name', 'LIKE', '%' . $this->query . '%')
                ->latest()
                ->take($this->creatorsLimit)
                ->get();
        }

        return view('livewire.search', [
            'works' => $works,
            'creators' => $creators,
            'hasMoreWorks' => $totalWorks > $this->worksLimit,
            'hasMoreCreators' => $totalCreators > $this->creatorsLimit,
        ]);
    }
}