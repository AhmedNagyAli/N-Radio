<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['country'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
