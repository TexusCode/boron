<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'user_id',
        'subtotal',
        'cashier_id',
        'delivery_price',
        'coupone_code',
        'tax',
        'discount',
        'total',
        'city',
        'location',
        'payment',
        'delivery_type',
        'note',
        'status',
        'cancellation_reason',
        'review_token',
        'deliver_boy_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
    public function courier()
    {
        return $this->belongsTo(User::class, 'deliver_boy_id');
    }

    public function suborders()
    {
        return $this->hasMany(SubOrder::class);
    }

    public function review()
    {
        return $this->hasOne(OrderReview::class);
    }
}
