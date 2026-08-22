<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    protected $table = 'app_notifications';

protected $fillable = [
    'user_id', 'type', 'related_work_id', 'message', 'is_read',
];

protected $casts = [
    'is_read' => 'boolean',
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function relatedWork()
{
    return $this->belongsTo(Work::class, 'related_work_id');
}
}
