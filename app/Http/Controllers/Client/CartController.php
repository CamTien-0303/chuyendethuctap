<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cartItems = collect();
        $subtotal = 0;

        if (Auth::check()) {
            // Logged-in users: get cart items from database
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
        } else {
            // Guests: get cart items from session
            $cart = session()->get('cart', []);
            $productIds = array_keys($cart);
            if (!empty($productIds)) {
                $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
                foreach ($cart as $productId => $item) {
                    if (isset($products[$productId])) {
                        $product = clone $products[$productId];
                        // Explicitly set the quantity on the object that will be used in the view
                        $product->quantity = $item['quantity'];
                        $product->id = $productId;
                        $cartItems->push($product);
                        $subtotal += $product->price * $product->quantity;
                    }
                }
            }
        }

        $discount = 0;
        $taxRate = 0.10;
        $tax = $subtotal * $taxRate;
        $shipping = ($subtotal > 0) ? 50000 : 0;
        $total = $subtotal + $tax + $shipping - $discount;

        return view('client.cart.index', compact('cartItems', 'subtotal', 'discount', 'tax', 'taxRate', 'shipping', 'total'));
    }

    /**
     * Add a product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $product = Product::findOrFail($productId);

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock for this product.');
        }

        if (Auth::check()) {
            // Logged-in users: store in database
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                // If item exists, increment the quantity
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // If item does not exist, create it
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            // Guests: store in session
            $cart = session()->get('cart', []);
            // Always set the quantity to the new value, or add it if it's not there.
            // This avoids issues with += on potentially non-existent keys.
            $currentQuantity = isset($cart[$productId]['quantity']) ? $cart[$productId]['quantity'] : 0;
            $cart[$productId] = ['quantity' => $currentQuantity + $quantity];
            session()->put('cart', $cart);
        }

        if ($request->ajax()) {
            // Return JSON response for AJAX requests
            $count = $this->getCartCount();
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'count' => $count
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Get current cart count
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            return array_sum(array_column($cart, 'quantity'));
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        if (Auth::check()) {
            // Logged-in users: update in database
            $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            if ($cartItem->product->stock < $quantity) {
                return redirect()->back()->with('error', 'Not enough stock for this product.');
            }
            $cartItem->update(['quantity' => $quantity]);
        } else {
            // Guests: update in session (the $id is the product_id)
            $cart = session()->get('cart', []);
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }
            if ($product->stock < $quantity) {
                return redirect()->back()->with('error', 'Not enough stock for this product.');
            }
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        if (Auth::check()) {
            // Logged-in users: delete from database
            Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        } else {
            // Guests: delete from session (the $id is the product_id)
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        if (Auth::check()) {
            // Logged-in users: delete all cart items from database
            Cart::where('user_id', Auth::id())->delete();
        } else {
            // Guests: clear session cart
            session()->forget('cart');
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        // Dummy function for coupon
        return redirect()->back()->with('coupon_message', 'Invalid coupon code.')->with('coupon_success', false);
    }

    /**
     * Migrate cart from session to database when user logs in
     */
    public static function migrateSessionCartToDatabase($userId)
    {
        $sessionCart = session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $item) {
            $existingCartItem = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existingCartItem) {
                // If item already exists in user's cart, add the session quantity
                $existingCartItem->quantity += $item['quantity'];
                $existingCartItem->save();
            } else {
                // Create new cart item
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        // Clear session cart after migration
        session()->forget('cart');
    }

    /**
     * Get cart count for AJAX requests
     */
    public function getCount()
    {
        $count = 0;

        if (Auth::check()) {
            // Logged-in users: count from database
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            // Guests: count from session
            $cart = session()->get('cart', []);
            $count = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json(['count' => $count]);
    }
}
