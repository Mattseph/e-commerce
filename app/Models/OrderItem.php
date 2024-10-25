<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{

    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'unit_price'
    ];

    public function order () {
        return $this->belongsTo(Order::class);
    }
}
