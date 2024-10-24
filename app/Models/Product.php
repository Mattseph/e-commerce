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

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function category() {
        $this->belongsTo(Category::class);
    }

    public function brand() {
        $this->belongsTo(Brand::class);
    }

    public function cart_items() {
        $this->hasMany(CartItem::class);
    }

    public function product_images() {
        $this->hasMany(ProductImage::class);
    }
}
