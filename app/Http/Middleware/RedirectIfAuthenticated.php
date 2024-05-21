<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $locale = $request->segment(1); // Assuming the locale is the first segment of the URL
                $adminPath = $locale . '/admin';
                $sellerPath = $locale . '/seller';

                if ($guard === 'admin' && ($request->is($adminPath) || $request->is($adminPath . '/*'))) {
                    return redirect(RouteServiceProvider::Admin); // Redirect to the Admin route
                } elseif ($guard === 'seller' && ($request->is($sellerPath) || $request->is($sellerPath . '/*'))) {
                    return redirect(RouteServiceProvider::Seller); // Redirect to the Seller route
                } else {
                    return redirect()->route('landing');
                }
            }
        }

        return $next($request);
    }
}
