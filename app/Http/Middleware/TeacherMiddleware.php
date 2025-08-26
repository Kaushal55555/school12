<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            \Log::warning('Unauthenticated user attempted to access teacher route');
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::user();
        $hasRole = $user->hasRole('teacher');
        
        \Log::info('TeacherMiddleware Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'has_teacher_role' => $hasRole,
            'roles' => $user->getRoleNames(),
            'path' => $request->path()
        ]);

        if (!$hasRole) {
            \Log::warning("User #{$user->id} with roles " . json_encode($user->getRoleNames()) . " attempted to access teacher route");
            return redirect()->route('home')->with('error', 'Access Denied. Teacher access only.');
        }

        // Ensure the teacher profile exists
        if (!$user->teacher) {
            \Log::error("User #{$user->id} has role 'teacher' but no associated teacher profile");
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is not properly configured. Please contact support.');
        }

        return $next($request);
    }
}
