<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'moysklad_id',
        'name',
        'description',
        'code',
        'stock',
        'price',
        'discount',
        'delivery',
        'miniature',
        'category_id',
        'subcategory_id',
        'sell',
        'istop',
        'status',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function otherphotos()
    {
        return $this->hasMany(OtherPhoto::class);
    }
}
