<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Diksat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == 0) {
            return redirect()->route('home');
        }

        if (Auth::user()->role == 1) {
            return redirect()->route('superadmin');
        }

        if (Auth::user()->role == 2) {
            return redirect()->route('admin');
        }

        if (Auth::user()->role == 3) {
            return redirect()->route('observer');
        }

        if (Auth::user()->role == 4) {
            return redirect()->route('warek');
        }

        if (Auth::user()->role == 5) {
            return redirect()->route('kajur');
        }


        if (Auth::user()->role == 6) {
            return redirect()->route('kaprodi');
        }

        if (Auth::user()->role == 7) {
            return redirect()->route('dikjur');
        }

        if (Auth::user()->role == 8) {

            return $next($request);
        }


        if (Auth::user()->role == 9) {
            return redirect()->route('dosen');
        }
    }
}
