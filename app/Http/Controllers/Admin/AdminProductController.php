<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Search functionality
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('brand', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->input('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by brand
        if ($request->has('brand_id') && $request->input('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        // Filter by status
        if ($request->has('status') && $request->input('status') !== '') {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by featured
        if ($request->has('featured') && $request->input('featured') !== '') {
            $query->where('is_featured', $request->input('featured'));
        }

        // Filter by stock status
        if ($request->has('stock_status')) {
            switch ($request->input('stock_status')) {
                case 'in_stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Validate sort fields
        $allowedSorts = ['id', 'name', 'price', 'stock', 'is_active', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);

        $products = $query->paginate(15);

        // Get filter options
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
            \Log::info('Product image uploaded: ' . $imagePath);
        }

        // Set boolean values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Set boolean values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Check if product has any order items
        if ($product->orderItems()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product because it has associated orders.');
        }

        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Handle bulk actions for products.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'action' => 'required|in:activate,deactivate,feature,unfeature,delete'
        ]);

        $productIds = $validated['product_ids'];
        $action = $validated['action'];
        $count = count($productIds);

        try {
            switch ($action) {
                case 'activate':
                    Product::whereIn('id', $productIds)->update(['is_active' => true]);
                    $message = "{$count} product(s) activated successfully.";
                    break;

                case 'deactivate':
                    Product::whereIn('id', $productIds)->update(['is_active' => false]);
                    $message = "{$count} product(s) deactivated successfully.";
                    break;

                case 'feature':
                    Product::whereIn('id', $productIds)->update(['is_featured' => true]);
                    $message = "{$count} product(s) marked as featured successfully.";
                    break;

                case 'unfeature':
                    Product::whereIn('id', $productIds)->update(['is_featured' => false]);
                    $message = "{$count} product(s) removed from featured successfully.";
                    break;

                case 'delete':
                    // Check if any products have order items
                    $productsWithOrders = Product::whereIn('id', $productIds)
                        ->whereHas('orderItems')
                        ->count();

                    if ($productsWithOrders > 0) {
                        return redirect()->route('admin.products.index')
                            ->with('error', 'Cannot delete products that have associated orders.');
                    }

                    // Delete images and products
                    $products = Product::whereIn('id', $productIds)->get();
                    foreach ($products as $product) {
                        if ($product->image) {
                            Storage::disk('public')->delete($product->image);
                        }
                    }
                    Product::whereIn('id', $productIds)->delete();
                    $message = "{$count} product(s) deleted successfully.";
                    break;
            }

            return redirect()->route('admin.products.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'An error occurred while processing the bulk action: ' . $e->getMessage());
        }
    }

    /**
     * Export products to CSV
     */
    public function export(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Apply same filters as index
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id') && $request->input('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('brand_id') && $request->input('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('is_active', $request->input('status'));
        }

        $products = $query->get();

        $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Category',
                'Brand',
                'Price',
                'Stock',
                'Is Active',
                'Is Featured',
                'Description',
                'Created At'
            ]);

            // Add data rows
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->category ? $product->category->name : '',
                    $product->brand ? $product->brand->name : '',
                    $product->price,
                    $product->stock,
                    $product->is_active ? 'Yes' : 'No',
                    $product->is_featured ? 'Yes' : 'No',
                    $product->description,
                    $product->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

