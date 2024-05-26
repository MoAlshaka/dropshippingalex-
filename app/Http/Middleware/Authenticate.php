<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            $locale = $request->segment(1);
            $adminPath = $locale . '/admin';
            $sellerPath = $locale . '/seller';
            if ($request->is($adminPath) || $request->is($adminPath . '/*')) {
                return route('get.admin.login');
            }
            if ($request->is($sellerPath) || $request->is($sellerPath . '/*')) {
                return route('get.seller.login');
            }
        }
        return route('landing');
    }
}
