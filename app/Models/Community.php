<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = [
    'name', 'slug', 'description', 'location', 'image',
];

public function members()
{
    return $this->hasMany(CommunityMember::class);
}

public function works()
{
    return $this->hasMany(Work::class);
}
}
