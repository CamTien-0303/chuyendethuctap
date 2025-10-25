<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate a unique username based on email
        $username = $this->generateUniqueUsername($request->email);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $username,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role for new users
        ]);

        // Create a corresponding customer entry
        Customer::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => 'N/A', // Default value, can be updated later by the user
            'address' => 'N/A', // Default value, can be updated later by the user
        ]);

        event(new Registered($user));

        Auth::login($user);

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
