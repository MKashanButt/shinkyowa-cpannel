<?php

namespace App\Http\Middleware;

use App\Models\CustomerAccounts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAccountRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request); // Skip if not logged in
        }

        if (Auth::user()->role == 'customer') {
            $cid = CustomerAccounts::where('customer_email', Auth::user()->email)->first()->customer_id;
            return redirect()->route('find-customer-account', ['id' => $cid]);
        }
        return $next($request);
    }
}
