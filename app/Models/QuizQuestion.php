<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
    'prompt', 'options', 'correct_option_id', 'explanation', 'status',
];

protected $casts = [
    'options' => 'array',
];
}
