<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu user đã login và là admin, không cho vào client routes
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin không thể truy cập phần client.');
        }

        return $next($request);
    }
}