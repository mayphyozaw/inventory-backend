<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'from_warehouse_id',
        'to_warehouse_id',
        'date',
        'note',
        'discount',
        'shipping',
        'grand_total',
        'status',
    ];


    public function fromWarehouse()
    {
        return $this->belongsTo(WareHouse::class, 'from_warehouse_id');
    }


    public function toWarehouse()
    {
        return $this->belongsTo(WareHouse::class, 'to_warehouse_id');
    }

    public function transferItems()
    {
        return $this->hasMany(TransferItem::class, 'transfer_id');
    }

    protected function acsrStatus(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['status']) {
                    case 'Pending':
                        $text = 'Pending';
                        $color = 'dc2626';
                        break;

                    case 'Ordered':
                        $text = 'Ordered';
                        $color = 'ea580c';
                        break;

                    case 'Transfer':
                        $text = 'Transfer';
                        $color = '16a34a';
                        break;

                    default:
                        $text = '';
                        $color = '4b45563';
                        break;
                }
                return [
                    'text' => $text,
                    'color' => $color
                ];
            },

        );
    }
}
