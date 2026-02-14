<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * ចំណុចសំខាន់៖ យើងត្រូវរក្សាទុក 'price' នៅទីនេះផងដែរ
     * មិនមែនគ្រាន់តែ Reference ទៅ Product ទេ។
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price', // តម្លៃលក់ជាក់ស្តែងនៅពេលនោះ (Snapshot Price)
    ];

    /**
     * ទំនាក់ទំនងទៅកាន់ Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * ទំនាក់ទំនងទៅកាន់ Product
     * ដើម្បីទាញយករូបភាព ឬឈ្មោះទំនិញមកបង្ហាញ
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Helper: គណនាតម្លៃសរុបនៃមុខទំនិញនេះ (Qty * Price)
     * ហៅប្រើក្នុង Blade: {{ $item->subtotal }}
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
