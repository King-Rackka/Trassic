<?php

namespace App\Livewire;

use App\Models\Bookmark;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookmarkButton extends Component
{
    public Work $work;
    public bool $isBookmarked = false;

    public function mount(Work $work, bool $isBookmarked = false)
    {
        $this->work = $work;
        $this->isBookmarked = $isBookmarked;
    }

    public function toggle()
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $existing = Bookmark::where('user_id', Auth::id())
            ->where('work_id', $this->work->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $this->isBookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => Auth::id(),
                'work_id' => $this->work->id,
            ]);
            $this->isBookmarked = true;
        }
    }

    public function render()
    {
        return view('livewire.bookmark-button');
    }
}