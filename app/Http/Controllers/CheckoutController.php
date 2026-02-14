<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; // ប្រាកដថាអ្នកមាន Model នេះ
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * បង្ហាញទំព័រ Checkout ជាមួយតម្លៃពិតប្រាកដ
     */
    public function index()
    {
        // ១. ទាញយកទិន្នន័យទំនិញក្នុងកន្ត្រករបស់ User ដែលកំពុង Login
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // ២. គណនាតម្លៃទំនិញសរុប (Subtotal)
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // ៣. កំណត់តម្លៃសេវាដឹកជញ្ជូន (យោងតាមរូបភាពគឺ $2.00)
        $shippingFee = 0.00;

        // ៤. គណនាតម្លៃសរុបចុងក្រោយ
        $totalAmount = $subtotal + $shippingFee;

        // ៥. រក្សាទុកតម្លៃក្នុង Session ដើម្បីឱ្យទំព័រ KHQR ទាញយកទៅប្រើបាន
        session(['total_amount' => $totalAmount]);

        // ៦. បញ្ជូនទិន្នន័យទៅកាន់ View
        return view('checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee,
            'totalAmount' => $totalAmount
        ]);
    }

    /**
     * បញ្ជាក់ការបង់ប្រាក់ (បន្ទាប់ពីចុចប៊ូតុង "ខ្ញុំបានបង់ប្រាក់រួចរាល់")
     */
    public function confirmPayment(Request $request)
    {
        // កូដសម្រាប់បង្កើត Order និងសម្អាត Cart បន្ទាប់ពីបង់ប្រាក់ជោគជ័យ
        // ...
        
        // បន្ទាប់ពីជោគជ័យ សម្អាត session តម្លៃ
        session()->forget('total_amount');

        return redirect()->route('home')->with('success', 'ការបង់ប្រាក់ទទួលបានជោគជ័យ!');
    }
}