<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'order_id',
        'lead_id',
        'date',
        'revenue',
        'is_received',
        'is_confirmed',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
