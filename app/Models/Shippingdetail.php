<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shippingdetail extends Model
{
    use HasFactory;

    protected $fillable=[
        'details','order_id'
    ];

    public function order(){
        return $this->belongsToMany(Order::class);
    }
}
