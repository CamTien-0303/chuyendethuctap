<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'price',
        'description',
        'image',
        'stock',
        'is_active',
        'is_featured',
    ];

    /**
     * Get the image path attribute.
     */
    protected function getImageAttribute($value)
    {
        if ($value && !str_starts_with($value, 'products/') && file_exists(storage_path('app/public/products/' . $value))) {
            return 'products/' . $value;
        }
        return $value;
    }

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the order items for the product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
