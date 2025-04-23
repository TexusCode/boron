<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OderCheckout extends Model
{
    use HasFactory;

    protected $fillable = [
        'cookie',
        'subtotal',
        'delivery_price',
        'coupone_code',
        'tax',
        'discount',
        'total',
    ];
}
