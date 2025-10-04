<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'image',
        
    ];

    protected function acsrImagePath(): Attribute
    {
    return Attribute::make(
        get: fn ($value, $attributes) =>
            $attributes['image']
                ? asset('upload/brand_images/'.$attributes['image'])
                : asset('upload/brand_images/default.png')
    );
    }

    
}
