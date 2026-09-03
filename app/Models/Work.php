<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'creator_id', 'community_id', 'title', 'slug', 'description',
        'category', 'year', 'location', 'story', 'process', 'status',
        'cover_image', 'is_featured', 'published_at', 'target_quantity',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'target_quantity' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(CreatorProfile::class, 'creator_id');
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function wasteDna()
    {
        return $this->hasMany(WasteDna::class);
    }

    public function images()
    {
        return $this->hasMany(WorkImage::class)->orderBy('sort_order');
    }

    public function appreciations()
    {
        return $this->hasMany(Appreciation::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(SubmissionFeedback::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Comment top-level aja (parent_id null) — reply-nya diakses lewat $comment->replies
    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id')
            ->with('user', 'likes', 'replies')
            ->withCount('likes')
            ->orderByDesc('created_at');
    }

    public function quantityForMaterial($wasteType = null)
    {
        if ($wasteType) {
            return $this->wasteDna->where('waste_type', $wasteType)->sum('quantity');
        }
        return $this->wasteDna->first()->quantity ?? 0;
    }

    public function totalWasteQuantity()
    {
        return $this->wasteDna->sum('quantity');
    }

    public function isBookmarkedBy($userId)
    {
        if (!$userId) return false;
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }

    // Karya lain yang mirip: kategori sama ATAU material sama, kecuali diri sendiri
    public function similarWorks($limit = 4)
    {
        $materials = $this->wasteDna->pluck('material');

        return Work::where('status', 'published')
            ->where('id', '!=', $this->id)
            ->where(function ($q) use ($materials) {
                $q->where('category', $this->category)
                  ->orWhereHas('wasteDna', fn($q2) => $q2->whereIn('material', $materials));
            })
            ->with('wasteDna', 'creator')
            ->withCount('appreciations')
            ->take($limit)
            ->get();
    }
}