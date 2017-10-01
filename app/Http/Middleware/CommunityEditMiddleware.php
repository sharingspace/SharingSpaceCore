<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class CommunityEditMiddleware
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
        log::debug('CommunityEditMiddleware: entered');
        if (!Auth::user()) {
            //log::debug('CommunityEditMiddleware: not logged in');
            return redirect('home');
        }
        else if (!(Auth::user()->isSuperAdmin() || Auth::user()->isAdminOfCommunity($request->whitelabel_group))) {
            //log::debug('CommunityEditMiddleware: user is login in but not an admin (share or super)');
            return redirect('home');
        }

        return $next($request);
    }
}
