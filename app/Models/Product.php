<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

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
