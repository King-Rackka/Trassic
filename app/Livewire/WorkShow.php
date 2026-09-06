<?php
namespace App\Livewire;

use App\Models\Work;
use App\Models\Appreciation;
use App\Models\Bookmark;
use App\Models\Report;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WorkShow extends Component
{
    public Work $work;

    public bool $showShareModal = false;
    public bool $showReportModal = false;
    public string $reportReason = '';
    public string $reportDetails = '';

    public function mount(Work $work)
    {
        $this->work = $work->load(['creator', 'wasteDna', 'images']);
    }

    public function toggleLike($workId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $appreciation = Appreciation::where('user_id', Auth::id())
            ->where('work_id', $workId)
            ->first();

        if ($appreciation) {
            $appreciation->delete();
        } else {
            Appreciation::create([
                'user_id' => Auth::id(),
                'work_id' => $workId,
            ]);
        }
    }

    // TOGGLE BOOKMARK
    public function toggleBookmark()
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('work_id', $this->work->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
        } else {
            Bookmark::create([
                'user_id' => Auth::id(),
                'work_id' => $this->work->id,
            ]);
        }
    }

    public function submitReport()
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $this->validate([
            'reportReason' => 'required|string',
            'reportDetails' => 'nullable|string|max:500',
        ]);

        Report::create([
            'reporter_id' => Auth::id(), 
            'work_id'     => $this->work->id,
            'reason'      => $this->reportReason,
            'message'     => $this->reportDetails, 
            'status'      => 'open',
        ]);

        $this->reset(['reportReason', 'reportDetails']);
        $this->js("showReportModal = false");
        $this->dispatch('notify', message: 'Laporan berhasil dikirim!');
    }

    public function render()
    {
        $creatorWorks = $this->work->creator->works()
            ->where('status', 'published')
            ->where('id', '!=', $this->work->id)
            ->withCount('appreciations')
            ->with('wasteDna')
            ->orderByDesc('published_at')
            ->take(10)
            ->get();

        $similarWorks = $this->work->similarWorks(4);

        $isBookmarked = Auth::check() ? $this->work->isBookmarkedBy(Auth::id()) : false;

        $maxLikes = Work::where('status', 'published')
            ->withCount('appreciations')
            ->get()
            ->max('appreciations_count');

        $currentLikes = $this->work->appreciations()->count();
        $isTopLiked = ($currentLikes > 0 && $currentLikes >= $maxLikes);

        return view('work-show', [
            'creatorWorks' => $creatorWorks,
            'similarWorks' => $similarWorks,
            'isBookmarked' => $isBookmarked,
            'isTopLiked' => $isTopLiked,
        ]);
    }
}