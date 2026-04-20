<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if user is not authenticated
        }

        $user = Auth::user();
        if (!$user->userType || !$user->userType->permissions) {
            abort(403, 'Unauthorized action.'); // No permissions at all
        }

        // By default JSON decoding yields an array because we stored JSON array in JS
        $permissions = json_decode($user->userType->permissions, true) ?? [];

        // Admin might have 'SA' override or something, but let's strictly follow the JSON array
        if (!in_array($permission, $permissions)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
