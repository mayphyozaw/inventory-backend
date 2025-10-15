<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [

        'id',
        'sale_id',
        'product_id',
        'net_unit_cost',
        'stock',
        'quantity',
        'discount',
        'subtotal',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class,'sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
