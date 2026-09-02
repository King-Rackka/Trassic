<?php

namespace App\Livewire;

use App\Models\Work;
use App\Models\WasteDna;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Appreciation;
use Illuminate\Support\Facades\Auth;

class ExploreMore extends Component
{
    use WithPagination;

    public $wasteType = '';

    public function mount($category = '')
    {
        $this->wasteType = $category;
    }

    public function setCategory($type)
    {
        $this->wasteType = $type === $this->wasteType ? '' : $type;
        $this->resetPage();
    }

    public function render()
    {
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
            ->paginate(15);

        return view('livewire.explore-more', [
            'works' => $works,
            'categories' => $categories,
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