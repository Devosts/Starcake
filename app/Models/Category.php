<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'description', 'is_active', 'sort_order'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name).'-'.Str::random(6);
            }
        });
    }
}
