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
          if (($request->whitelabel_group->group_type=='O') || ($request->whitelabel_group->group_type=='S')) {


            // If the user is logged in, check that they are a member
            // and are allowed to see this group
            if (Auth::check()) {

                  $logged_in_user = Auth::user();

                  if ($logged_in_user->isMemberOfCommunity($request->whitelabel_group->id)) {
                    return $next($request);

                  } else {
                    echo 'Must be a member';
                    exit;
                  }

            // User is not logged in
            } else {
              echo 'Must be logged in';
              exit;
            }

          }

        }

        return $next($request);
    }
}
