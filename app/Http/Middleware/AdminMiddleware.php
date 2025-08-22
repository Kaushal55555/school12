<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            \Log::info('AdminMiddleware: User not authenticated');
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $user = Auth::user();
        $hasRole = $user->hasRole('admin');
        
        \Log::info('AdminMiddleware Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'has_admin_role' => $hasRole,
            'roles' => $user->getRoleNames(),
            'path' => $request->path()
        ]);

        if (!$hasRole) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
