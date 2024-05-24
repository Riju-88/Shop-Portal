<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'items'
    ];

    // To display items and quantity of order in filament table
    public function getTotalItemsAttribute()
    {
        $items = json_decode($this->items, true);
        $productNames = [];
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $productNames[] = $product->name . '(' . $item['quantity'] . ')';
            }
        }
        return implode(', ', $productNames);
    }
}
