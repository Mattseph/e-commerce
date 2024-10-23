<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{

    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'product_id',
        'quantity'
    ];

    public function product() {
        $this->belongsTo(Product::class);
    }
}
