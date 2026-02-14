<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * កំណត់ Field ដែលអាចបញ្ចូលទិន្នន័យបាន
     */
    protected $fillable = [
        'user_id',
        'total_price',
        'status',          // ឧ. pending, paid, cancelled
        'payment_method',  // ឧ. KHQR, Cash
        'order_type',      // ឧ. delivery, pickup, dine_in
    ];

    /**
     * ទំនាក់ទំនងជាមួយ User (១ Order ជារបស់ ១ User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ទំនាក់ទំនងជាមួយ OrderItem (១ Order មានទំនិញច្រើនមុខ)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * (Optional) ទំនាក់ទំនងទៅកាន់ Product ដោយផ្ទាល់
     * ប្រើពេលចង់ដឹងថា Order នេះមានផលិតផលអ្វីខ្លះ ដោយមិនចង់ loop តាម items
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    /**
     * Helper Function: សម្រាប់បង្ហាញពណ៌ Badge ទៅតាម Status
     * ហៅប្រើក្នុង Blade: {!! $order->status_badge !!}
     */
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'paid':
                return '<span class="badge bg-success">បានបង់ប្រាក់ (Paid)</span>';
            case 'pending':
                return '<span class="badge bg-warning text-dark">រង់ចាំ (Pending)</span>';
            case 'cancelled':
                return '<span class="badge bg-danger">បានលុបចោល (Cancelled)</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>';
        }
    }
}
