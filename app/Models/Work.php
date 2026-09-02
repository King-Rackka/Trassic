<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
    'creator_id', 'community_id', 'title', 'slug', 'description',
    'category', 'year', 'location', 'story', 'process', 'status',
    'cover_image', 'is_featured', 'published_at',
];

protected $casts = [
    'is_featured' => 'boolean',
    'published_at' => 'datetime',
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

public function isAppreciatedBy($userId)
{
    if (!$userId) return false;
    return $this->appreciations()->where('user_id', $userId)->exists();
}

public function quantityForMaterial($wasteType = null)
{
    if ($wasteType) {
        return $this->wasteDna->where('waste_type', $wasteType)->sum('quantity');
    }
    return $this->wasteDna->first()->quantity ?? 0;
}


public function scopeSearch($query, $keyword)
{
    return $query->where('status', 'published')
        ->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhereHas('creator', function ($q2) use ($keyword) {
                  $q2->where('name', 'like', "%{$keyword}%");
              });
        });
}

}
