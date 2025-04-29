<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['city', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
