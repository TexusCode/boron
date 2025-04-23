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
        'deliver_boy_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deliver()
    {
        return $this->belongsTo(Deliver::class, 'deliver_boy_id');
    }

    public function suborders()
    {
        return $this->hasMany(SubOrder::class);
    }
}
