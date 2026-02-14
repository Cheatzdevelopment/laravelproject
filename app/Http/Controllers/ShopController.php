<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * បង្ហាញទំព័រហាង (Shop Page)
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. ទាញយកផលិតផលដែលមានស្តុក (Stock > 0)
        $products = Product::where('stock', '>', 0)
                           ->latest()
                           ->paginate(12);

        // 2. ទាញយកទិន្នន័យកន្ត្រកទំនិញ (ដោះស្រាយ Error: Undefined variable $cartItems)
        $cartItems = Cart::where('user_id', $userId)
                        ->with('product') // ប្រើ Eager Loading ដើម្បីឱ្យដើរលឿន
                        ->get();

        // 3. គណនាតម្លៃសរុប (Total Price)
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // បញ្ជូនទៅកាន់ view 'home' ជាមួយ variables គ្រប់គ្រាន់
        return view('home', compact('products', 'cartItems', 'total'));
    }

    /**
     * ដាក់ទំនិញចូលកន្ត្រក (Add to Cart)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock <= 0) {
            return back()->with('error', 'ទំនិញនេះអស់ស្តុកហើយ!');
        }

        $userId = Auth::id();

        // ឆែកមើលទំនិញក្នុងកន្ត្រក
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            if ($cartItem->quantity + 1 > $product->stock) {
                return back()->with('error', 'ចំនួនទំនិញក្នុងស្តុកមិនគ្រប់គ្រាន់!');
            }
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'បានដាក់ចូលកន្ត្រកជោគជ័យ!');
    }

    /**
     * លុបចេញពីកន្ត្រក
     */
    public function removeFromCart($cartId)
    {
        $cartItem = Cart::where('user_id', Auth::id())->find($cartId);

        if ($cartItem) {
            $cartItem->delete();
            return back()->with('success', 'បានលុបចេញពីកន្ត្រក!');
        }

        return back()->with('error', 'រកមិនឃើញទិន្នន័យ!');
    }
}