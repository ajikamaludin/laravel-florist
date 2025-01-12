<?php

namespace App\Models;

use App\Models\Default\Model;
use App\Models\Default\User;

class Store extends Model
{
    protected $fillable = [
        'name',
        'city',
        'phone',
        'address',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'store_id');
    }
}
