<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{

    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'type',
        'created_by',
        'updated_by',
    ];

    public function order () {
        $this->belongsTo(Order::class);
    }
}
