<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the wishlist items.
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('client.account.wishlist', compact('wishlistItems'));
    }

    /**
     * Add a product to the wishlist.
     */
    public function add($product)
    {
        // Check if the product is already in the wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'This product is already in your wishlist.');
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product
        ]);

        return redirect()->back()->with('success', 'Product added to your wishlist.');
    }

    /**
     * Remove a product from the wishlist.
     */
    public function remove($wishlistItem)
    {
        // Find the wishlist item and verify ownership in a single query
        $deleted = Wishlist::where('id', $wishlistItem)
            ->where('user_id', Auth::id())
            ->delete();

        if (!$deleted) {
            abort(404);
        }

        return redirect()->back()->with('success', 'Product removed from your wishlist.');
    }

    /**
     * Display the public wishlist page
     */
    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login to view your wishlist');
        }

        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('client.wishlist', compact('wishlistItems'));
    }
}
