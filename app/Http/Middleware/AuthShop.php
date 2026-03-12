<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthShop
{
    /**
     * Handle an incoming request.
     * Yeh middleware check karta hai ke user login hai ya nahi
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Session mein shop_domain check karna
        if (!Session::has('shop_domain')) {
            // Agar login nahi hai toh error dikhana
            return redirect('/')->with('error', 'Please login first');
        }

        // Agar login hai toh aage jane dena
        return $next($request);
    }
}
