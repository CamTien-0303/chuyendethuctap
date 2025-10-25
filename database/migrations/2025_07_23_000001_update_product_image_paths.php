<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First check if any products don't have the correct image path format
        $products = DB::table('products')->whereNotNull('image')->get();

        foreach ($products as $product) {
            $image = $product->image;

            // If image path doesn't start with "products/" add it
            if ($image && !str_starts_with($image, 'products/')) {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['image' => 'products/' . $image]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration can't be reversed as we don't know which paths were modified
    }
};
