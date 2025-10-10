<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [

        'id',
        'purchase_id',
        'product_id',
        'net_unit_cost',
        'stock',
        'quantity',
        'discount',
        'subtotal',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'product_id', 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'purchase_id');
    }

}
