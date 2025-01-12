<?php

namespace App\Models;

use App\Models\Default\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'city',
        'phone',
        'address',
    ];
}
