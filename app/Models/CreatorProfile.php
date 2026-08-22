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
}
