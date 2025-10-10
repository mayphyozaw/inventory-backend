<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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
    ];

    public function purchaseItem()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'purchase_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id', 'purchase_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'purchase_id');
    }


    protected function acsrStatus(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['status']) {
                    case 'pending':
                        $text = 'Pending';
                        $color = 'ea580c';
                        break;

                    case 'ordered':
                        $text = 'Ordered';
                        $color = '16a34a';
                        break;

                    case 'received':
                        $text = 'Received';
                        $color = 'dc2626';
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
