<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name',
        'store_phone',
        'description',
        'logo',
        'patent',
        'passport_front',
        'passport_back',
        'moy_sklad',
        'moysklad_login',
        'moysklad_password',
        'status',
        'isverified',
        'register_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suborders()
    {
        return $this->hasMany(SubOrder::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function moysklad()
    {
        return $this->hasOne(MoySklad::class);
    }
}
