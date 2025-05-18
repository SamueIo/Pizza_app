<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $fillable = [
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

    protected $casts = [
        'cart_data' => 'array',
        'total_price' => 'decimal:2',
    ];

    /**
     * Vzťah k používateľovi (ak objednávku zadáva prihlásený používateľ)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
