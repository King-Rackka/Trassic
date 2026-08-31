<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatorProfile extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'bio', 'profile_image', 'cover_image',
        'creator_type', 'location', 'social_links', 'phone',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class, 'creator_id');
    }

    public function publishedWorksCount()
    {
        return $this->works()->where('status', 'published')->count();
    }

    public function recentWorks($limit = 4)
    {
        return $this->works()
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->take($limit)
            ->get();
    }

    public function followersCount()
    {
        return \App\Models\Follow::where('target_type', 'creator')
            ->where('target_id', $this->id)
            ->count();
    }

    public function isFollowedBy($userId)
    {
        if (!$userId) return false;
        return \App\Models\Follow::where('target_type', 'creator')
            ->where('target_id', $this->id)
            ->where('user_id', $userId)
            ->exists();
    }

    public function followingCount()
    {
        return \App\Models\Follow::where('user_id', $this->user_id)->count();
    }

    // 🟢 BARU — ambil website & instagram dari kolom social_links (json), tanpa perlu kolom baru
   public function website()
    {
        // Cek kolom database langsung 'website' ATAU di dalam json 'social_links'
        return $this->attributes['website'] 
            ?? ($this->social_links['website'] ?? null);
    }

    public function instagramHandle()
    {
        // Cek kolom 'instagram', 'instagram_handle', ATAU di dalam json 'social_links'
        return $this->attributes['instagram']
            ?? $this->attributes['instagram_handle']
            ?? ($this->social_links['instagram'] ?? $this->social_links['ig'] ?? null);
    }
}