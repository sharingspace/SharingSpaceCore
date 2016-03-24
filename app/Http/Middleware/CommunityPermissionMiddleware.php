<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;


class CommunityPermissionMiddleware
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

        // This is a whitelabel group, otherwise skip it
        if ($request->whitelabel_group) {
            LOG::debug('Whitelabel routing: This is a valid whitelabel group.');
          // This group is not restricted
          if ($request->whitelabel_group->group_type=='O') {
              LOG::debug('Whitelabel routing: This is an open group');
              return $next($request);

          } else {
            // If the user is logged in, check that they are a member
            // and are allowed to see this group
            if (Auth::check()) {

                LOG::debug('Whitelabel routing: User is logged in.');
                if (Auth::user()->canSeeCommunity($request->whitelabel_group)) {
                    LOG::debug('Whitelabel routing: This user is authorized to see this.');
                    return $next($request);
                } else {
                    LOG::debug('Whitelabel routing: User is not allowed to view this group.');
                    return view('request-access')->withError('You must be a member of this group to view this page.');
                }

            // User is not logged in
            } else {
                LOG::debug('Whitelabel routing: User is not logged in.');
                if ($request->whitelabel_group->group_type=='S') {
                    LOG::debug('Whitelabel routing: User is not logged in and this community requires authorization.');
                    return view('auth/login-unbranded')->withError('You must be logged in and a member to see this.');
                }
                LOG::debug('Whitelabel routing: User is not logged in, but the community does not require authorization.');
                return $next($request);

            }

          }

        }

        return $next($request);
    }
}
