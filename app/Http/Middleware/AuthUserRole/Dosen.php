<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Dosen
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
        $roles=Auth::user()->roles->first()->id;

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($roles == 0) {
            return redirect()->route('home');
        }

        if ($roles == 1) {
            return redirect()->route('superadmin');
        }

        if ($roles == 2) {
            return redirect()->route('admin');
        }

        if ($roles == 3) {
            return redirect()->route('observer');
        }

        if ($roles == 4) {
            return redirect()->route('warek');
        }

        if ($roles == 5) {
            return redirect()->route('kajur');
        }


        if ($roles == 6) {
            return redirect()->route('kaprodi');
        }

        if ($roles == 7) {
            return redirect()->route('dikjur');
        }

        if ($roles == 8) {

            return redirect()->route('diksat');
        }


        if ($roles == 9) {

            return $next($request);
        }
    }
}
