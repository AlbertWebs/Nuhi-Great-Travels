<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            $authHeader = $request->header('Authorization');
            if ($authHeader) {
                $token = str_replace('Bearer ', '', $authHeader);
            }
        }
        
        if ($token) {
            $hashedToken = hash('sha256', $token);
            $user = User::where('api_token', $hashedToken)->first();
            
            if ($user) {
                $request->setUserResolver(function () use ($user) {
                    return $user;
                });
                // Also set it for auth() helper
                auth()->setUser($user);
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated'
        ], 401);
    }
}
