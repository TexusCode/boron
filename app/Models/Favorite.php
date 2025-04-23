<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "product_id",
    ];

    public function product() // Изменено на product, так как каждый избранный элемент связан с одним продуктом
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Исправлено на user_id
    }
}
