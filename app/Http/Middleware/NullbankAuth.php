<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NullbankAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!isset($_SESSION)){
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
