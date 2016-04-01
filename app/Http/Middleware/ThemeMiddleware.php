<?php
/**
 * This Middleware checks for a theme preference based on the
 * $request->valid_whitelabel object we set in the
 * SubdomainMiddleware.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Middleware;

use Closure;
use Theme;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->valid_whitelabel === true) {
            if ($request->whitelabel_group->theme!='') {
                Theme::init($request->whitelabel_group->theme);
            } else {
                Theme::init('whitelabel');
            }

        } else {
            Theme::init('default');
        }

        return $next($request);
    }
}
