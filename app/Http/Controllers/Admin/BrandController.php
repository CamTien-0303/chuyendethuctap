<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Brand::query();

        // Search functionality
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('website', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->input('status') !== '') {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        // Validate sort fields
        $allowedSorts = ['id', 'name', 'is_active', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $brands = $query->orderBy($sortBy, $sortDirection)->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $brand = new Brand();
        $brand->name = $validated['name'];
        $brand->description = $validated['description'] ?? null;
        $brand->website = $validated['website'] ?? null;
        $brand->is_active = isset($validated['is_active']) ? true : false;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
            $brand->image = $imagePath;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::with('products')->findOrFail($id);
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $validated['name'];
        $brand->description = $validated['description'] ?? null;
        $brand->website = $validated['website'] ?? null;
        $brand->is_active = isset($validated['is_active']) ? true : false;

        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $imagePath = $request->file('image')->store('brands', 'public');
            $brand->image = $imagePath;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);

        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Cannot delete brand because it has associated products.');
        }

        // Delete image if exists
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
