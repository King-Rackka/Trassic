<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionFeedback extends Model
{
    protected $fillable = ['work_id', 'admin_id', 'message'];

public function work()
{
    return $this->belongsTo(Work::class);
}

public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}
}
