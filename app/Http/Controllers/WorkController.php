<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class WorkController extends Controller
{
    public function show(Work $work)
    {
        $work->load(['creator', 'wasteDna', 'images']);

        $creatorWorks = $work->creator->works()
            ->where('status', 'published')
            ->where('id', '!=', $work->id)
            ->withCount('appreciations')
            ->with('wasteDna')
            ->orderByDesc('published_at')
            ->take(10)
            ->get();

        $similarWorks = $work->similarWorks(4);

        return view('work-show', [
            'work' => $work,
            'creatorWorks' => $creatorWorks,
            'similarWorks' => $similarWorks,
            'isBookmarked' => Auth::check() ? $work->isBookmarkedBy(Auth::id()) : false,
            'appreciationsCount' => $work->appreciations()->count(),
        ]);
    }
    public function create()
    {
        return view('work-create');
    }

    public function destroy(Work $work)
{
    $user = Auth::user();

    $isOwner = $user && (
        $user->id === ($work->creator->user_id ?? null) || 
        (isset($user->creatorProfile) && $user->creatorProfile->id === $work->creator_id)
    );

    if (!$isOwner) {
        abort(403, 'Kamu tidak memiliki akses untuk menghapus karya ini.');
    }

    // Hapus cover image dari storage jika ada
    if ($work->cover_image && Storage::disk('public')->exists($work->cover_image)) {
        Storage::disk('public')->delete($work->cover_image);
    }

    // Hapus data karya (relasi seperti wasteDna dan gambar galeri akan ikut terhapus jika diset cascade)
    $work->delete();

    return redirect()->route('profile.show')->with('message', 'Karya berhasil dihapus!');
}
    

}