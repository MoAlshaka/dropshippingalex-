<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'revenue',
        'date',
        'updated_by',
        'status',

    ];



    // The admin who updated the record
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
