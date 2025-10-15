<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnPurchaseItem extends Model
{
    protected $fillable = [
        'id',
        'return_purchase_id',
        'product_id',
        'net_unit_cost',
        'stock',
        'quantity',
        'discount',
        'subtotal',
    ];

    public function returnpurchase()
    {
        return $this->belongsTo(ReturnPurchase::class,'return_purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
