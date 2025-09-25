<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $latestProducts = Product::where('is_active', true)->latest()->take(20)->get();
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->take(8)
            ->get();

        return view('client.home', compact(
            'banners',
            'categories',
            'latestProducts',
            'featuredProducts'
        ));
    }
}
