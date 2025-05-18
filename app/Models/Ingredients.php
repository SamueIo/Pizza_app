<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];
    public function scopeActive($query)
    {
    return $query->where('is_active', true);
    }


}
