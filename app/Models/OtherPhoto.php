<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'product_id',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
