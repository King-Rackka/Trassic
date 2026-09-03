<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Work;
use App\Models\CreatorProfile;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    use WithPagination;

    public $activeFilter = 'diposting'; 

    public function setFilter($filter)
    {
        $this->activeFilter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $creator = CreatorProfile::where('user_id', $user->id)->firstOrFail();

        $worksQuery = Work::query()->withCount('appreciations');

        if ($this->activeFilter === 'diposting') {
            $worksQuery->where('creator_profile_id', $creator->id);
        } elseif ($this->activeFilter === 'disukai') {
            $worksQuery->whereHas('appreciations', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } elseif ($this->activeFilter === 'favorit') {
            $worksQuery->where('creator_profile_id', $creator->id)->where('is_favorite', true);
        } elseif ($this->activeFilter === 'dilaporkan') {
            $worksQuery->where('creator_profile_id', $creator->id)->where('status', 'reported');
        }

        $works = $worksQuery->latest()->paginate(10);

        $postsCount = Work::where('creator_profile_id', $creator->id)->count();
        $followersCount = Follow::where('target_type', 'creator')->where('target_id', $creator->id)->count();
        $followingCount = Follow::where('user_id', $user->id)->count();

        return view('livewire.profile.show', [
            'creator' => $creator,
            'user' => $user,
            'works' => $works,
            'postsCount' => $postsCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
        ]);
    }
}