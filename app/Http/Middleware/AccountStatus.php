<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Illuminate\Support\Facades\Auth;

class AccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $status = Auth::user()->status;

        if ($status == 0) {
            return Redirect::route('login.index')->with('error', 'Akun anda belum diaktifkan.');
        } else if($status == 2){
            return Redirect::route('login.index')->with('error', 'Akun anda telah dinonaktifkan.');
        }

        return $next($request);
    }
}
