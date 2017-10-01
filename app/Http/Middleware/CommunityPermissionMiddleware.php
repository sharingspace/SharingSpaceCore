<?php
/**
 * This Middleware does a high-level check to see whether
 * or not the community is visible. More finely-tuned permissions
 * are handled via the gates defined in AuthServiceProvider.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class CommunityPermissionMiddleware
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
        //log::debug('CommunityPermissionMiddleware: entered');

        // This is a whitelabel group, otherwise skip it
        if ($request->whitelabel_group) {
            //log::debug('CommunityPermissionMiddleware: This is a valid whitelabel group.');
            if ($request->whitelabel_group->group_type != 'O') {
                //log::debug('CommunityPermissionMiddleware: This is a closed or secret group');

                // If the user is logged in, check that they are a member and are allowed to see this group
                if (Auth::check()) {
                    //log::debug('CommunityPermissionMiddleware: User is logged in');
                    if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
                        //log::debug('CommunityPermissionMiddleware: This user is authorized to see this community');
                        return $next($request);
                    }
                    else if ($request->whitelabel_group->group_type == 'C') {
                        $request_count = $request->whitelabel_group->getRequestCount(Auth::user()->id);
                        //log::debug('CommunityPermissionMiddleware: Closed hub, request_count = '.$request_count."  request path=".$request->path()."=");

                        if (($request->path() == "members") || ($request->path() == "entry/json.browse") || ($request->path() == "/")) {
                            //log::debug('CommunityPermissionMiddleware: we let users see the browse and members page');

                            // they can see this page
                            return $next($request);
                        }
                        else if ($request_count) {
                            $request_count++; // user alreday has a request pending, this will trigger the correct message
                            //log::debug('CommunityPermissionMiddleware: user has already requested to join Share '.$request_count.'   '.$request->whitelabel_group->name);
                            return redirect()->route('community.request-access.form');
                        }
                        else {
                            //log::debug('CommunityPermissionMiddleware: first request to join Share '.$request->whitelabel_group->name);
                            return redirect()->route('community.request-access.form');
                        }
                    }
                    else {
                        //log::debug('CommunityPermissionMiddleware: Hub is secret but user is not a member');
                        return view('login-unbranded')->withError('Secret Hub. You must be invited to join this hub');
                    }
                }
                else { // User is not logged in
                    //log::debug('CommunityPermissionMiddleware: User is not logged in.');
                    if ($request->whitelabel_group->group_type == 'S') {
                        //log::debug('CommunityPermissionMiddleware: User is not logged in and this community is secret.');
                        return redirect()->route('login.unbranded')->withError('This hub is secret. You must be invited to join this hub.');
                    }
                    else {
                        if ($request->path() == "members") {
                            // we let people see some pages of an open share
                            return $next($request);
                        }
                        //log::debug('CommunityPermissionMiddleware: User is not logged in and this community is closed, redirecting to login page');
                        return redirect()->route('login');
                    }
                }
            }
        }
        
        return $next($request);
    }
}
