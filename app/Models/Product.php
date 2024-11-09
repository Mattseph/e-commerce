<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{

    use HasFactory, HasSlug;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'brand_id',
        'title',
        'slug',
        'quantity',
        'description',
        'published',
        'inStock',
        'price',
        'created_by',
        'updated_by',
    ];

    protected $with = ['category', 'brand', 'product_images'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function cart_items() {
        return $this->hasMany(CartItem::class);
    }

    public function product_images() {
        return $this->hasMany(ProductImage::class);
    }
}
