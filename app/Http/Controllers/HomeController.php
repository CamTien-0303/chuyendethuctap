<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        try {
            // Get active banners
            $banners = Banner::where('is_active', true)->get();
            
            // Get categories with products
            $categories = Category::with('products')->get();
            
            // Get latest featured products
            $products = Product::with(['category', 'brand'])
                        ->where('is_active', true)
                        ->orderBy('created_at', 'desc')
                        ->take(8)
                        ->get();
            
            return view('client.home', compact('banners', 'categories', 'products'));
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('HomeController error: ' . $e->getMessage());
            
            // Return view with empty data
            return view('client.home', [
                'banners' => collect(),
                'categories' => collect(),
                'products' => collect()
            ]);
        }
    }
}