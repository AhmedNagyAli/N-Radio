<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'image', 'src', 'status',
        'country_id', 'city_id', 'type', 'language_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function likedByUsers()
{
    return $this->belongsToMany(User::class, 'station_user')->withTimestamps();
}

    // public function getStatusAttribute($value)
    // {
    //     return $value == '1' ? 'Active' : 'Not Active';
    // }
}
