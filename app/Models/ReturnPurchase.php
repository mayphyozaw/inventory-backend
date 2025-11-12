<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchase extends Model
{
    protected $fillable = [
        'warehouse_id',
        'supplier_id',
        'date',
        'grand_total',
        'note',
        'discount',
        'status',
        'create_at',
        'shipping',
    ];

    public function returnPurchaseItems()
    {
        return $this->hasMany(ReturnPurchaseItem::class,'return_purchase_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

     protected function acsrStatus(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['status']) {
                    case 'Return':
                        $text = 'Return';
                        $color = '16a34a';
                        break;

                    case 'Pending':
                        $text = 'Pending';
                        $color = 'dc2626';
                        break;

                    case 'Ordered':
                        $text = 'Ordered';
                        $color = 'ea580c';
                        break;

                    
                    default:
                        $text = '';
                        $color = '4b45563';
                        break;
                }
                return[
                    'text' => $text,
                    'color'=> $color
                ];
            },
            
        );
    }
    
}
