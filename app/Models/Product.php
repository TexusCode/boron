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

    public function getAutoDiscountPercentAttribute(): float
    {
        return Coupone::autoDiscountPercentForCategory($this->category_id);
    }

    public function getDisplayPriceAttribute(): float
    {
        $price = $this->discount ?? $this->price;
        $percent = $this->auto_discount_percent;

        if ($percent > 0) {
            $price = $price * (1 - ($percent / 100));
        }

        return round($price, 2);
    }

    public function getTotalDiscountPercentAttribute(): int
    {
        if (!$this->price || $this->price <= 0) {
            return 0;
        }

        return max(0, (int) round((1 - ($this->display_price / $this->price)) * 100));
    }
}
