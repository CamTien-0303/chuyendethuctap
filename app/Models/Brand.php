<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'website',
        'is_active',
    ];

    /**
     * Get the products for the brand
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
