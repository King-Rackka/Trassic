<?php

namespace App\Livewire;

use App\Models\Work;
use App\Models\WasteDna;
use Livewire\Component;
use App\Models\Appreciation;
use Illuminate\Support\Facades\Auth;

class Explore extends Component
{
    public $wasteType = '';

    public function setCategory($type)
    {
        $this->wasteType = $type === $this->wasteType ? '' : $type;
    }

    public function render()
    {
        $topWorks = Work::query()
            ->where('status', 'published')
            ->withCount(['appreciations as weekly_likes' => function ($q) {
                $q->where('created_at', '>=', now()->subDays(7));
            }])
            ->with(['creator', 'wasteDna'])
            ->orderByDesc('weekly_likes')   
            ->orderByDesc('published_at') 
            ->take(3)
            ->get();

        $categories = WasteDna::distinct()->pluck('waste_type');

        $works = Work::query()
            ->where('status', 'published')
            ->with(['creator', 'wasteDna'])
            ->withCount('appreciations')
            ->when($this->wasteType, function ($q) {
                $q->whereHas('wasteDna', function ($q2) {
                    $q2->where('waste_type', $this->wasteType);
                });
            })
            ->orderByDesc('published_at')
            ->take(10)
            ->get();

        return view('livewire.explore', [
            'topWorks' => $topWorks,
            'categories' => $categories,
            'works' => $works,
            'category' => $this->wasteType,
        ]);
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
}