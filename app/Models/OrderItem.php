<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $table = 'order_items';

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'unit_price'
    ];
    
    public function order () {
        $this->belongsTo(Order::class);
    }
}
