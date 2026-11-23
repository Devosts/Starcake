<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'image', 'gallery',
        'unit', 'stock', 'price', 'sale_price', 'is_sale', 'badge',
        'is_featured', 'is_active', 'sort_order', 'description',
        'meta',
    ];

    protected $casts = [
        'gallery' => 'array',
        'meta' => 'array',
        'is_sale' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /** Discounted price (use sale price when active). */
    public function effectivePrice(): Attribute
    {
        return Attribute::get(fn () => $this->is_sale && $this->sale_price ? $this->sale_price : $this->price);
    }

    /** Full URL for the product main image, supporting remote & local paths. */
    public function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            $img = $this->image;
            if (! $img) {
                return asset('images/placeholder-product.svg');
            }
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                return $img;
            }

            return asset('storage/'.$img);
        });
    }

    public function ratingAvg()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating');
    }
}
