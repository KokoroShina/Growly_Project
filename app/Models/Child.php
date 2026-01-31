<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'user_id','name','birth_date','gender','photo_path','notes'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(related: User::class);
    }

    public function measurements()
    {
        return $this->hashMany(Measurement::class)->latest('date');
    }

    public function latestMeasurement()
    {
        return $this->hasOne(Measurement::class)->latessOfMany();
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    } 

    public function getAgeInMonthsAttribute ()
    {
        return $this->birth_age->diffInMonths(now());
    }

}
