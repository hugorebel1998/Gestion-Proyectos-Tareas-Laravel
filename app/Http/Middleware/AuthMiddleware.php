<?php

namespace App\Http\Middleware;

use App\Factories\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('Authorization');

        if (isset($header)) {
            $token = explode(' ', $header)[1];
            $response = Auth::validateBearerToken($token);

            if ($response['success']) {
                $request->attributes->add(['auth' => $response['user']]);
            }
            return $next($request);
        } else if ($request->path() == 'api/v1/auth/login') {
            return $next($request);
        } else {
            return response()->json(['success' => false, 'message' => 'Acceso no autorizado'], 401);
        }
    }
}
