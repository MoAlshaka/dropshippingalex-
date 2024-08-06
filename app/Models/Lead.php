<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_date',
        'store_reference',
        'store_name',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_mobile',
        'customer_address',
        'customer_city',
        'customer_country',
        'item_sku',
        'warehouse',
        'quantity',
        'total',
        'currency',
        'status',
        'type',
        'seller_id',
        'notes',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
    public function sharedproduct()
    {
        return $this->belongsTo(SharedProduct::class, 'item_sku', 'sku');
    }
    public function affiliateproduct()
    {
        return $this->belongsTo(AffiliateProduct::class, 'item_sku', 'sku');
    }
}
