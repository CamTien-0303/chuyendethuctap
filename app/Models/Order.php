<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'notes',
    ];

    /**
     * Get the customer that owns the order
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order items for the order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the products for the order through order items
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
