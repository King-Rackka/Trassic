<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatorProfile extends Model
{
    protected $fillable = [
    'user_id', 'name', 'slug', 'bio', 'profile_image',
    'creator_type', 'location', 'social_links',
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

}
