<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'warehouse_id',
        'supplier_id',
        'name',
        'code',
        'image',
        'price',
        'stock_alert',
        'note',
        'product_qty',
        'discount',
        'status',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }


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
