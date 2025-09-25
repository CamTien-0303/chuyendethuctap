<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'is_active',
        'sort_order',
    ];

    /**
     * Get the products for the category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
