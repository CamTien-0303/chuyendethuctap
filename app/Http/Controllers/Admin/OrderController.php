<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'orderItems']);

        // Search functionality
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }

        // Filter by date range
        if ($request->has('from_date') && $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->has('to_date') && $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Validate sort fields
        $allowedSorts = ['id', 'total_amount', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);

        $orders = $query->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('admin.orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'shipping_address' => 'nullable|string|max:255',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $total_amount = 0;
        $orderItemsData = [];

        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            if (!$product)
                continue;

            $total_amount += $product->price * $item['quantity'];
            $orderItemsData[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ];

            // Decrease stock
            $product->decrement('stock', $item['quantity']);
        }

        $order = Order::create([
            'customer_id' => $validated['customer_id'],
            'total_amount' => $total_amount,
            'subtotal_amount' => $total_amount, // Simplified for now
            'tax_amount' => 0, // Simplified for now
            'shipping_amount' => 0, // Simplified for now
            'status' => $validated['status'],
            'shipping_address' => $validated['shipping_address'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_status'],
        ]);

        $order->orderItems()->createMany($orderItemsData);

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        $customers = Customer::all();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,refunded,failed',
            'shipping_address' => 'nullable|string|max:255',
        ]);

        // Note: This does not handle stock changes if an order is cancelled.
        // The previous logic for stock restoration on cancellation has been removed
        // as part of this update to align with the new form fields.
        // If an order is cancelled, you might want to manually adjust stock
        // or implement a more robust inventory management system.

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng #' . $order->id . ' đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // If not cancelled, restore product stock
        if ($order->status != 'cancelled') {
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }
        }

        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
