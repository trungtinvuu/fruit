<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->only('email', 'password');

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'Invalid email'], 400);
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            return response()->json(['error' => 'Password must be at least 6 characters long'], 400);
        }

        return $next($request);
    }
}
