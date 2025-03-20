<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('firebase_user')) {
            return redirect()->route('login')->with('error', 'Please log in first.');
            dd(session('firebase_user'));
        }

        return $next($request);
    }
}
