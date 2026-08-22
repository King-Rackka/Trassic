<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteDna extends Model
{
    protected $table = 'waste_dna';

protected $fillable = [
    'work_id', 'material', 'waste_type', 'source',
    'quantity', 'unit', 'item_count', 'processing_method',
];

public function work()
{
    return $this->belongsTo(Work::class);
}
}
