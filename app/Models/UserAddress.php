<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{

    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'type',
        'address1',
        'address2',
        'city',
        'state',
        'zipcode',
        'isMain',
        'country_code',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
