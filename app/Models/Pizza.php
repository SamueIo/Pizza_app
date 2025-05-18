<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Psy\Readline\Hoa\FileLink;

class Pizza extends Model
{
    protected $fillable = ['name','size', 'description', 'price', 'image'];
}
