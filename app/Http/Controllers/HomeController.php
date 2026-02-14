<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart; 
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // ១. បង្វែរទិសដៅទៅតាមតួនាទី (Role-based Redirection)
        if ($role == 'owner') {
            return redirect()->route('owner.dashboard');
        }
        if ($role == 'cashier') {
            return redirect()->route('cashier.dashboard');
        }
        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // ២. ទាញយកទិន្នន័យផលិតផលសម្រាប់ Customer (Paginate 12)
        $products = Product::where('stock', '>', 0)
                           ->latest()
                           ->paginate(12);

        // ៣. ទាញយកទិន្នន័យកន្ត្រកទិញ (Cart Items)
        // ប្រើ with('product') ដើម្បីទាញយកទិន្នន័យផលិតផលក្នុងពេលតែមួយ (Eager Loading)
        $cartItems = $user->cartItems()->with('product')->get();

        // ៤. គណនាតម្លៃសរុបក្នុងកន្ត្រក ($total) ដើម្បីបំបាត់ Error
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // បញ្ជូន Variable ទាំងអស់ទៅកាន់ View
        return view('home', compact('products', 'cartItems', 'total'));
    }
}