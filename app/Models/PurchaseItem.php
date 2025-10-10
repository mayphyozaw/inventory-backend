<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
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

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'product_id', 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'purchase_id');
    }

}
