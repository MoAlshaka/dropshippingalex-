<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipment_status',
        'lead_id',
        'seller_id',
    ];

    public function lead(){
        return $this->belongsTo(Lead::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
