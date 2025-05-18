<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'note',
        'cart_data',
        'total_price',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
