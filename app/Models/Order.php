<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Order extends Model
{
    use HasFactory , SoftDeletes , HasRoles , HasPermissions;

    protected $fillable = 
    [
        'user_id' , 'description'
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }
}
