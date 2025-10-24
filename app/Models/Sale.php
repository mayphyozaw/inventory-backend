<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'warehouse_id',
        'customer_id',
        'date',
        'note',
        'discount',
        'shipping',
        'grand_total',
        'paid_amount',
        'due_amount',
        'status',
        'create_at',
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class,'sale_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id');
    }

    protected function acsrStatus(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                switch ($attributes['status']) {
                    case 'Pending':
                        $text = 'Pending';
                        $color = 'dc2626';
                        break;

                    case 'Ordered':
                        $text = 'Ordered';
                        $color = 'ea580c';
                        break;

                    case 'Sale':
                        $text = 'Sale';
                        $color = '16a34a';
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
