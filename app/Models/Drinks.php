<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drinks extends Model
{
    protected $fillable =
    [
        'name',
        'description',
        'price',
        'available',
        'path',
    ];
}
