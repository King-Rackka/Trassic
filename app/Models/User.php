<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];

    public function creatorProfile()
{
    return $this->hasOne(CreatorProfile::class);
}

public function communityMemberships()
{
    return $this->hasMany(CommunityMember::class);
}

public function appreciations()
{
    return $this->hasMany(Appreciation::class);
}

public function bookmarks()
{
    return $this->hasMany(Bookmark::class);
}

public function follows()
{
    return $this->hasMany(Follow::class);
}

public function notifications()
{
    return $this->hasMany(AppNotification::class);
}

public function unreadNotifications()
{
    return $this->hasMany(AppNotification::class)->where('is_read', false);
}

}
