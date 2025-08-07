<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $fillable = [
        'product_id',
        'ingredient_id',
    ];
}
