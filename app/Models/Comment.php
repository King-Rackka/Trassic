<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'work_id', 'user_id', 'parent_id', 'content',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Reply langsung di bawah comment ini (bukan cucu/great-grandchild —
    // di desain replies cuma 1 level dalam, jadi ini cukup)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->with('user', 'likes')
            ->withCount('likes')
            ->orderBy('created_at');
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function isLikedBy($userId)
    {
        if (!$userId) return false;
        return $this->likes()->where('user_id', $userId)->exists();
    }
}