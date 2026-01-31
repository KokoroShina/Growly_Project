<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'child_id','title','description','is_completed','date'
    ];

    protected $casts = [
    'date'=> 'date',
    'is_completed' =>  'boolean',
    ];

    public function child ()
    {
        return $this->belongsTo(Child::class);
    }
}
