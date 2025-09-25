<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Get or create customer for the user
        $customer = $user->customer ?? \App\Models\Customer::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => 'N/A',
            'address' => 'N/A',
        ]);

        // Get recent orders through customer
        $recentOrders = $customer->orders()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get total orders count
        $totalOrders = $customer->orders()->count();

        // Get total spent
        $totalSpent = $customer->orders()
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        return view('client.account.dashboard', compact('user', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    /**
     * Display the user orders.
     */
    public function orders()
    {
        $user = auth()->user();

        // Get or create customer for the user
        $customer = $user->customer ?? \App\Models\Customer::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => 'N/A',
            'address' => 'N/A',
        ]);

        $orders = $customer->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.account.orders', compact('orders'));
    }

    /**
     * Display the user profile.
     */
    public function profile()
    {
        $user = auth()->user();

        return view('client.account.profile', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Check current password if trying to update password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.')->withInput();
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Display the user addresses.
     */
    public function addresses()
    {
        $user = auth()->user();

        return view('client.account.addresses', compact('user'));
    }

    /**
     * Update the user addresses.
     */
    public function updateAddresses(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
        ]);

        // Update user address information
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        $user->phone = $request->phone;

        $user->save();

        return redirect()->route('account.addresses')->with('success', 'Addresses updated successfully.');
    }
}
