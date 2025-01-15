<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGuestAndRespond
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                    'shouldOpenModal' => true
                ], 401);
            }

            // Store intended URL
            session()->put('url.intended', url()->previous());

            // Redirect to home with query parameter
            return redirect()->route('users.home', ['openLogin' => true]);
        }

        return $next($request);
    }
}
