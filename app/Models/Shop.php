<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['shopName' , 'postalCode' , 'telephone' , 'phoneNumber' , 'address' , 'lng' , 'lat'] ;

    public function locations(): MorphMany
    {
        return $this->morphMany(Location::class, 'locationable');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
