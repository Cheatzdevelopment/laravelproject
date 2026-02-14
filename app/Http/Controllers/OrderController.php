<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * បង្ហាញទំព័រ Checkout និង QR ជាមួយដឹកជញ្ជូនឥតគិតថ្លៃ
     */
    public function checkout(Request $request)
    {
        // ១. ទាញយកទំនិញក្នុងកន្ត្រក
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'កន្ត្រករបស់អ្នកទទេ!');
        }

        // ២. គណនាតម្លៃ
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingFee = 0; // កែប្រែមកជាឥតគិតថ្លៃ (Free)
        $totalAmount = $subtotal + $shippingFee;

        // ៣. រក្សាទុកក្នុង Session
        $orderType = $request->input('type', 'delivery');
        session([
            'checkout_order_type' => $orderType,
            'checkout_total_amount' => $totalAmount 
        ]);

        // ៤. បញ្ជូនអថេរទៅកាន់ View
        return view('checkout.payment', compact('totalAmount', 'subtotal', 'shippingFee'));
    }

    /**
     * ដំណើរការបង្កើត Order និងកាត់ស្តុក
     */
    public function confirmPayment(Request $request)
    {
        $user = Auth::user();

        try {
            return DB::transaction(function () use ($user) {
                $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

                if ($cartItems->isEmpty()) {
                    return redirect()->route('home');
                }

                // គណនាតម្លៃសរុបពិតប្រាកដក្នុង Server (Free Shipping)
                $subtotal = $cartItems->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });
                
                $shippingFee = 0; // ត្រូវតែដូចគ្នានឹង function checkout
                $totalPrice = $subtotal + $shippingFee;

                // បង្កើត Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $totalPrice,
                    'order_type' => session('checkout_order_type', 'delivery'),
                    'payment_method' => 'KHQR',
                    'status' => 'paid',
                ]);

                foreach ($cartItems as $item) {
                    // ពិនិត្យស្តុក
                    if ($item->product->stock < $item->quantity) {
                        throw new \Exception("ទំនិញ {$item->product->name} អស់ស្តុកហើយ!");
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price
                    ]);

                    // កាត់ស្តុក
                    $item->product->decrement('stock', $item->quantity);
                }

                // លុប Cart និង Session បន្ទាប់ពីជោគជ័យ
                Cart::where('user_id', $user->id)->delete();
                session()->forget(['checkout_order_type', 'checkout_total_amount']);

                return redirect()->route('invoice', $order->id)->with('success', 'ការទូទាត់ជោគជ័យ!');
            });
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }

    public function invoice($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        
        if (Auth::user()->role == 'user' && $order->user_id != Auth::id()) {
            abort(403);
        }

        return view('invoice.show', compact('order'));
    }
}