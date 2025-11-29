<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupone extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'percent',
        'status',
        'scope',
        'category_id',
        'auto_apply',
    ];

    protected $casts = [
        'percent' => 'float',
        'status' => 'boolean',
        'auto_apply' => 'boolean',
    ];

    protected static $autoCouponsCache;

    protected static function booted(): void
    {
        static::saved(function () {
            static::clearAutoCouponsCache();
        });

        static::deleted(function () {
            static::clearAutoCouponsCache();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function autoDiscountPercentForCategory(?int $categoryId): float
    {
        $coupons = static::autoCoupons();
        $percent = 0;

        foreach ($coupons as $coupon) {
            if ($coupon->scope === 'all' || ($coupon->scope === 'category' && $coupon->category_id == $categoryId)) {
                $percent = max($percent, (float) $coupon->percent);
            }
        }

        return $percent;
    }

    protected static function autoCoupons()
    {
        if (is_null(static::$autoCouponsCache)) {
            static::$autoCouponsCache = static::where('status', true)
                ->where('auto_apply', true)
                ->get();
        }

        return static::$autoCouponsCache;
    }

    public static function clearAutoCouponsCache(): void
    {
        static::$autoCouponsCache = null;
    }
}
