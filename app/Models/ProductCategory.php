<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'category_name',
        'category_slug',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
