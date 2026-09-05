<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Work;
use App\Models\CreatorProfile;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use App\Models\Appreciation;

class Show extends Component
{
    use WithPagination;

    public $activeFilter = 'diposting';
    public $isEditMode = false;

    public function setFilter($filter)
    {
        $this->activeFilter = $filter;
        $this->resetPage();

        if ($filter !== 'diposting') {
            $this->isEditMode = false;
        }
    }

    public function toggleEditMode()
    {
        $this->isEditMode = !$this->isEditMode;
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

    public function render()
{
    $user = Auth::user();

    $creator = CreatorProfile::firstOrCreate(
        ['user_id' => $user->id],
        [
            'name' => $user->name,
            'slug' => \Illuminate\Support\Str::slug($user->name . '-' . $user->id),
        ]
    );

    $worksQuery = Work::query()->with(['creator.user', 'wasteDna'])->withCount('appreciations');

    if ($this->activeFilter === 'diposting') {
        $worksQuery->where('creator_id', $creator->id);
    } elseif ($this->activeFilter === 'disukai') {
        $worksQuery->whereHas('appreciations', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    } elseif ($this->activeFilter === 'favorit') {
        $worksQuery->whereHas('bookmarks', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    } elseif ($this->activeFilter === 'dilaporkan') {
        $worksQuery->where('creator_id', $creator->id)->where('status', 'reported');
    }

    $works = $worksQuery->latest()->paginate(10);

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
        'activeFilter' => $this->activeFilter,   // ini juga hilang, dibutuhkan blade untuk @entangle
    ]);
}

    
}