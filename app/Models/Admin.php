<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'username',
        'password',
        'access_token',
        'status',
        'roles_name',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function sharedproducts()
    {
        return $this->hasMany(SharedProduct::class);
    }
    public function affiliateproducts()
    {
        return $this->hasMany(AffiliateProduct::class);
    }

    protected $casts = [
        // 'roles_name' => 'array',
    ];
}
