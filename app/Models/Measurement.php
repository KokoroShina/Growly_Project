<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = 
    [
        'child_id','date','weight','height','z_score_weight', 'z_score_height','status','notes'
    ];


    protected $casts = [
    'date'=> 'date',
    'weight'=> 'decimal:2',
    'height'=> 'decimal:2',
    ];

    public function child ()
    {
        return $this->belongsTo(Child::class);
    }
}
