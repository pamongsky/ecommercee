<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',          // tambahkan slug nanti
        'category_id',
        'stock',
        'price',
        'is_active',
        'image_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }
}
