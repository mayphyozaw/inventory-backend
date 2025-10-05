<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
