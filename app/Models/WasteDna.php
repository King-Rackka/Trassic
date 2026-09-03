<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteDna extends Model
{
    protected $table = 'waste_dna';

    protected $fillable = [
        'work_id', 'material', 'waste_type', 'source',
        'quantity', 'unit', 'item_count', 'processing_method',
        'supporting_materials', 'usage_result',
    ];

    protected $casts = [
        'supporting_materials' => 'array',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}