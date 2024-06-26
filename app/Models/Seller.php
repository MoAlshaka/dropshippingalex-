<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [

        'email',
        'password',
        'national_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'image',
        'payment_method',
        'account',
        'is_active',
        'about_us',
    ];

    public function sharedProducts()
    {
        return $this->belongsToMany(SharedProduct::class, 'shared_product_seller');
    }

    public function affiliateProducts()
    {
        return $this->belongsToMany(AffiliateProduct::class, 'affiliate_product_seller');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

}
