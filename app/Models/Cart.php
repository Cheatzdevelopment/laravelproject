<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * កំណត់វាលដែលអាចបញ្ចូលទិន្នន័យបាន
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];
    public function index()
{
    // ទាញយកកន្ត្រករបស់ User ម្នាក់ៗ រួមជាមួយព័ត៌មាន Product
    $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

    // គណនាតម្លៃសរុប (Subtotal)
    $subtotal = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    $shippingFee = 2.00; // តម្លៃដឹកជញ្ជូនដែលឃើញក្នុងរូបភាព
    $totalAmount = $subtotal + $shippingFee;

    // បញ្ជូនទៅកាន់ View
    return view('checkout', compact('cartItems', 'subtotal', 'shippingFee', 'totalAmount'));
}
    /**
     * ទំនាក់ទំនងទៅកាន់ User (Belongs To User)
     * ដើម្បីដឹងថា កន្ត្រកនេះជារបស់អ្នកណា
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ទំនាក់ទំនងទៅកាន់ Product (Belongs To Product)
     * ដើម្បីដឹងថា ក្នុងកន្ត្រកនេះមានទំនិញឈ្មោះអ្វី តម្លៃប៉ុន្មាន រូបអ្វី...
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
