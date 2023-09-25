<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = 
    [
        'user_id' , 'product_id' , 'number' , 'color' , 'price' , 'total_price' , 'description' , 'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
