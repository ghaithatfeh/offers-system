<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status == 0) {
            $message = __('Your account has been suspended. Please contact administrator.');
            if (auth()->user()->role == 'Store Owner' && auth()->user()->store->status == 'Expired')
                $message = __('Your account is expired. Please contact administrator.');
            auth()->logout();
            return redirect()->route('login')->withMessage($message);
        }

        return $next($request);
    }
}
