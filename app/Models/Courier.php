<?php

namespace App\Models;

use App\Models\Default\Model;

class Courier extends Model
{
    protected $fillable = [
        'name',
        'address'
    ];
}
