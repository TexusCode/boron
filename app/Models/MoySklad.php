<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoySklad extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'login',
        'password',
        'token',
        'status',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
