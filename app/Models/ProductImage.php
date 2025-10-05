<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class ProductImage extends Model
{
    protected $fillable = [
        'id',
        'product_id',
        'image',
    ];

    protected function acsrImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) =>
            $attributes['image']
                ? asset('upload/product_images/' . $attributes['image'])
                : asset('upload/product_images/default.png')
        );
    }
}
