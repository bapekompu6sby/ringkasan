<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AllRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::check()){
        //     return redirect()->back();
        // }
        // return $next($request);

        if (!Auth::check()){
            return redirect()->back()->with('error', 'Anda harus login terlebih dahulu');
        }
        return $next($request);
    }
}
