<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = 
    [
        'productName', 'number', 'color', 'price', 'productImage' , 'addedBy'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
    

    public function opportunities()
    {
        return $this->belongsToMany(Opportunity::class);
    }
}
