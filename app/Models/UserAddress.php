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
        $this->belongsTo(User::class);
    }

    public function orders() {
        $this->hasMany(Order::class);
    }
}
