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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Jika tidak ada permission yang diperlukan, lanjutkan request
        if (!$permission) {
            return $next($request);
        }
        
        // Jika user memiliki permission yang diperlukan, lanjutkan request
        $user = Auth::user();
        if ($user->hasPermissionTo($permission)) {
            return $next($request);
        }
        
        // Jika user memiliki role super-admin, lanjutkan request
        if ($user->hasRole('super admin')) {
            return $next($request);
        }
        
        // Jika user tidak memiliki permission yang diperlukan, tampilkan error
        abort(403, 'Unauthorized action. You do not have the required permission: ' . $permission);
    }
}