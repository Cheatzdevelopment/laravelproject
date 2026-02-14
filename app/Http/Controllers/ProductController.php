<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * បង្ហាញបញ្ជីទំនិញទាំងអស់ (Read)
     */
    public function index()
    {
        // ទាញយកទិន្នន័យទំនិញទាំងអស់មកបង្ហាញ
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * បង្ហាញ Form បង្កើតទំនិញថ្មី (Create Form)
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * រក្សាទុកទិន្នន័យទំនិញថ្មីចូល Database (Store)
     */
    public function store(Request $request)
    {
        // ១. Validation (បន្ថែម category ទៅក្នុង Validation)
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string', // ✅ បន្ថែមថ្មី
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'image.max' => 'រូបភាពមិនអាចមានទំហំធំជាង 10MB បានទេ។',
            'category.required' => 'សូមជ្រើសរើសប្រភេទអាហារ។',
        ]);

        // ២. ដំណើរការរូបភាព (Image Upload)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileNameToStore = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $fileNameToStore, 'public');
            $imagePath = 'products/' . $fileNameToStore;
        }

        // ៣. បង្កើតទិន្នន័យថ្មី (បន្ថែម category)
        Product::create([
            'name' => $request->name,
            'category' => $request->category, // ✅ បន្ថែមថ្មី
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'ទំនិញត្រូវបានបង្កើតដោយជោគជ័យ!');
    }

    /**
     * បង្ហាញ Form កែប្រែទំនិញ (Edit Form)
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * ធ្វើបច្ចុប្បន្នភាពទិន្នន័យ (Update)
     */
    public function update(Request $request, $id)
    {
        // ១. Validation (បន្ថែម category)
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string', // ✅ បន្ថែមថ្មី
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $product = Product::findOrFail($id);
        $imagePath = $product->image;

        // ២. ពិនិត្យមើលថាតើមានការប្តូររូបភាពថ្មីទេ?
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $file = $request->file('image');
            $fileNameToStore = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $fileNameToStore, 'public');
            $imagePath = 'products/' . $fileNameToStore;
        }

        // ៣. Update Database (បន្ថែម category)
        $product->update([
            'name' => $request->name,
            'category' => $request->category, // ✅ បន្ថែមថ្មី
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'ទិន្នន័យទំនិញត្រូវបានកែប្រែជោគជ័យ!');
    }

    /**
     * លុបទំនិញ (Delete)
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // ១. លុបទំនិញនេះចេញពីកន្ត្រក (Cart) ជាមុន
        Cart::where('product_id', $id)->delete();

        // ២. លុបរូបភាព
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // ៣. លុបចេញពី Database
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'មុខទំនិញត្រូវបានលុបចេញពីប្រព័ន្ធ!');
    }
}