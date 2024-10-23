<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{

    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_address_id',
        'total_price',
        'status',
        'session_id',
        'created_by',
        'updated_by',
    ];

    public function user() {
        $this->belongsTo(User::class);
    }

    public function user_address() {
        $this->belongsTo(UserAddress::class);
    }

    public function order_items() {
        $this->hasMany(OrderItem::class);
    }

    public function payment () {
        $this->hasOne(Payment::class);
    }


}
