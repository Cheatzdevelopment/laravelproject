<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * កំណត់ Field ដែលអនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យ (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'category',    // ✅ បន្ថែមថ្មី ដើម្បីឱ្យអាច Save ប្រភេទអាហារបាន
        'price',
        'stock',
        'description',
        'image',
    ];

    /**
     * ✅ Casts: កំណត់ប្រភេទទិន្នន័យដោយស្វ័យប្រវត្តិ
     */
    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
    ];

    /**
     * ========================
     * RELATIONS (ទំនាក់ទំនង)
     * ========================
     */

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * ========================
     * SCOPES (សម្រាប់ចម្រាញ់ទិន្នន័យ)
     * ========================
     */

    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope សម្រាប់ឆែកតាមប្រភេទអាហារ
     * ហៅប្រើ: Product::byCategory('ភេសជ្ជៈ')->get();
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * ========================
     * ACCESSORS (Helper Attributes)
     * ========================
     */

    /**
     * ទាញយក Link រូបភាព (Image URL)
     * ហៅប្រើ: $product->image_url
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return 'https://via.placeholder.com/400x300.png?text=No+Image';
    }

    /**
     * បង្ហាញស្ថានភាពស្តុកជា HTML Badge (Premium Style 2026)
     * ហៅប្រើ: {!! $product->stock_status !!}
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return '<span class="status-badge status-out">Out of Stock</span>';
        } elseif ($this->stock <= 5) {
            return '<span class="status-badge status-low">Low Stock (' . $this->stock . ')</span>';
        } else {
            return '<span class="status-badge status-ok">Healthy</span>';
        }
    }

    /**
     * បង្ហាញឈ្មោះប្រភេទអាហារដែលមាន Emoji
     */
    public function getCategoryLabelAttribute()
    {
        $icons = [
            'អាហារពេលព្រឹក' => '🥐',
            'អាហារថ្ងៃត្រង់' => '🍱',
            'ភេសជ្ជៈ'      => '☕',
        ];

        $icon = $icons[$this->category] ?? '📦';
        return $icon . ' ' . ($this->category ?? 'មិនកំណត់');
    }

    /**
     * ពិនិត្យស្តុក
     */
    public function hasStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }
}