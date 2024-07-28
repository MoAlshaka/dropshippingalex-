<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipment_status',
        'payment_status',
        'payment_type',
        'calls',
        'lead_id',
        'seller_id',
        'quantity',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function shippingdetails()
    {
        return $this->hasMany(Shippingdetail::class);
    }
}
