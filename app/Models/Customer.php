<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable =
        [
            'firstName' , 'middleName' , 'lastName', 'fatherName' , 'email' , 'age' , 'birthDate' , 'nationalCode' , 
            'gender' , 'phoneNumber', 'country' , 'city' , 'address' , 'education' , 'job' , 'password'
        ];

    protected $hidden = 
    [
        'password'
    ];

    protected $casts = 
    [
        'password'=>'hashed'
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

    public function fuctures(){
        return $this->hasMany(Facture::class);
    }

}
