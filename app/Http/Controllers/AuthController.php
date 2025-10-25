<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Client\CartController;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            // Check if user is admin
            if ($user->role !== 'admin') {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // This would normally use Laravel's password reset functionality
        // But for simplicity, we'll just redirect with a message
        return back()->with('status', 'Password reset link sent to your email!');
    }

    public function resetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // This would normally use Laravel's password reset functionality
        // But for simplicity, we'll just redirect with a message
        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}
