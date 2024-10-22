<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
