<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'count',
        'price',
        'discount',
        'seller_id',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    // В модели SubOrder
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
