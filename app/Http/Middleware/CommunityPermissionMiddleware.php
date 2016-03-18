<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


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

          // This group is restricted
          if (($request->whitelabel_group->group_type=='C') || ($request->whitelabel_group->group_type=='S')) {


            // If the user is logged in, check that they are a member
            // and are allowed to see this group
            if (Auth::check()) {

                  $logged_in_user = Auth::user();

                  if ($logged_in_user->isMemberOfCommunity($request->whitelabel_group)) {
                    return $next($request);

                  } else {

                      if ($request->whitelabel_group->group_type=='S') {
                        return redirect(route('login'))->withError('You must be a member of this group to view this page.');
                      }

                  }

            // User is not logged in
            } else {
                if ($request->whitelabel_group->group_type=='S') {

                } elseif ($request->whitelabel_group->group_type=='C') {
                     return redirect(route('login'))->withError('You must be logged in to see this.');
                }

            }

          }

        }

        return $next($request);
    }
}
