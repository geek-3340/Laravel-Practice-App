<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorCodeIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$request->session()->get('two_factor_authenticated') &&
                $user->two_factor_code &&
                $user->two_factor_expires_at > now() &&
                !$request->is('verify-pin')
                ) {
                return redirect()->route('verify.pin');
            }
        }

        return $next($request);
    }
}
