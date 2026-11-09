<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Pemakaian di route:
     *   ->middleware('role:admin')
     *   ->middleware('role:admin,merchant')   // multiple role
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Belum login -> arahkan ke halaman login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Sudah login tapi role tidak diizinkan -> 403
        if (! in_array(Auth::user()->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
