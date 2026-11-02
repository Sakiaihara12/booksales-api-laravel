<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan rolenya adalah 'admin'
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Akses ini khusus untuk Admin!'
        ], 403);
    }
}