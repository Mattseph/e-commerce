<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    public function user() {
        $this->belongsTo(User::class);
    }

    public function orders() {
        $this->hasMany(Order::class);
    }
}
