<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];


    public function sheared_products()
    {
        return $this->hasMany(SharedProduct::class);
    }
    public function affiliate_products()
    {
        return $this->hasMany(AffiliateProduct::class);
    }
}
