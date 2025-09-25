<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function loginForm()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('client.auth.login');
    }

    /**
     * Handle client login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            // Kiểm tra nếu user là admin, redirect về admin dashboard
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to admin dashboard!');
            }

            // Migrate session cart to database (chỉ cho user thường)
            CartController::migrateSessionCartToDatabase(auth()->id());

            // Redirect to intended route or home
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the registration form.
     */
    public function registerForm()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('client.auth.register');
    }

    /**
     * Handle client registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Generate a unique username based on email
        $username = $this->generateUniqueUsername($validated['email']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $username,
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Đảm bảo user mới tạo từ client sẽ có role 'user'
        ]);

        // Create a corresponding customer entry
        Customer::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => 'N/A', // Default value, can be updated later by the user
            'address' => 'N/A', // Default value, can be updated later by the user
        ]);

        // Log the user in
        auth()->login($user);

        // Migrate session cart to database
        CartController::migrateSessionCartToDatabase(auth()->id());

        return redirect()->route('home')->with('success', 'Welcome! Your account has been created successfully.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Generate a unique username based on email
     */
    private function generateUniqueUsername($email)
    {
        // Get the part before @ from email
        $baseUsername = explode('@', $email)[0];

        // Remove any special characters and convert to lowercase
        $baseUsername = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($baseUsername));

        // Ensure username is not empty
        if (empty($baseUsername)) {
            $baseUsername = 'user';
        }

        $username = $baseUsername;
        $counter = 1;

        // Check if username exists and append number if needed
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
