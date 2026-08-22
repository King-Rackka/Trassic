<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
    'reporter_id', 'work_id', 'reason', 'message', 'status',
];

public function reporter()
{
    return $this->belongsTo(User::class, 'reporter_id');
}

public function work()
{
    return $this->belongsTo(Work::class);
}
}
