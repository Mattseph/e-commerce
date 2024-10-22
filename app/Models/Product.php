<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
