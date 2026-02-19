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
        return $this->hasMany(Measurement::class)->latest('date');
    }

    public function latestMeasurement()
    {
        return $this->hasOne(Measurement::class)->latestOfMany();
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    } 

    public function getAgeInMonthsAttribute ()
    {
        return $this->birth_date->diffInMonths(now());
    }

    public function getPhotoUrlAttribute ()
    {
        if($this->photo_path && file_exists(storage_path('app/public/'. $this->photo_path)))
            {
                return asset('storage/' . $this->photo_path);
            }

            //nge return emoji berdasarkan gambar nya
            return $this->gender == 'male' ? '👦' : '👧';
    }

    public function hasPhoto()
    {
        return !is_null($this->photo_path) && file_exists(storage_path('app/public/'. $this->photo_path));
    }

}
