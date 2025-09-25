<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of all products
     */
    public function index(Request $request)
    {
        try {
            // Check if there are any products
            $totalProducts = Product::count();

            $query = Product::query();

            // Apply category filter
            if ($request->has('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            // Apply brand filter
            if ($request->has('brand_id')) {
                $query->where('brand_id', $request->input('brand_id'));
            }

            // Apply price range filter
            if ($request->has('min_price') && is_numeric($request->input('min_price'))) {
                $query->where('price', '>=', $request->input('min_price'));
            }

            if ($request->has('max_price') && is_numeric($request->input('max_price'))) {
                $query->where('price', '<=', $request->input('max_price'));
            }

            // Apply search
            if ($request->has('search') && $request->input('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error loading products: ' . $e->getMessage());
            // Return empty query in case of error
            $query = Product::query();
        }

        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'price_low_high':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('client.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Display products by category
     */
    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();
        $title = $category->name;

        return view('client.products.index', compact('products', 'categories', 'brands', 'category', 'title'));
    }

    /**
     * Display products by brand
     */
    public function brand(Brand $brand)
    {
        $products = Product::where('brand_id', $brand->id)
            ->latest()
            ->paginate(12);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();
        $title = $brand->name;

        return view('client.products.index', compact('products', 'categories', 'brands', 'brand', 'title'));
    }

    /**
     * Display product details
     */
    public function show(Product $product)
    {
        // Get related products
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('brand_id', $product->brand_id);
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('client.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        // Redirect to index which already handles the search parameter
        return $this->index($request);
    }
}
