<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getRouteKeyName()
    {
        return 'slug';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'banner',
        'shop_name',
        'slug',
        'isVerified',
        'address',
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function scopeVerified($query)
    {
        $query->where('isVerified', 1);
    }
}
