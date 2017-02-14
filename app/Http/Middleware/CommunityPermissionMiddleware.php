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
        // This is a whitelabel group, otherwise skip it
        if ($request->whitelabel_group) {
            //LOG::debug('CommunityPermissionMiddleware: This is a valid whitelabel group.');
            if ($request->whitelabel_group->group_type == 'S') {
                LOG::debug('CommunityPermissionMiddleware: This is a secret group');

                // If the user is logged in, check that they are a member and are allowed to see this group
                if (Auth::check()) {
                    LOG::debug('CommunityPermissionMiddleware: User is logged in');
                    if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
                        LOG::debug('CommunityPermissionMiddleware: This user is authorized to see this community');
                        return $next($request);
                    }
                    else if ($request->whitelabel_group->group_type=='C') {
                        $request_count = $request->whitelabel_group->getRequestCount(Auth::user()->id);
                        LOG::debug('CommunityPermissionMiddleware: Closed hub, request_count = '.$request_count);

                        if ($request_count) {
                            $request_count++; // user alreday has a request pending, this will trigger the correct message
                            LOG::debug('CommunityPermissionMiddleware: user has already requested to join Share');
                            return view('request-access', ['request_count'=>$request_count, 'name' => $request->whitelabel_group->name] );
                        }
                        else {
                            LOG::debug('CommunityPermissionMiddleware: first request to join Share');
                            return view('request-access', ['request-access' => 0, 'name' => $request->whitelabel_group->name] );
                        }
                    }
                    else {
                        LOG::debug('CommunityPermissionMiddleware: Hub is secret but user is not a member');
                        return view('auth/login-unbranded')->withError('Secret Hub. You must be invited to join this hub');
                    }
                }
                else { // User is not logged in
                    LOG::debug('CommunityPermissionMiddleware: User is not logged in.');
                    if ($request->whitelabel_group->group_type=='S') {
                        LOG::debug('CommunityPermissionMiddleware: User is not logged in and this community is secret.');
                        return view('auth/login-unbranded')->withError('This hub is secret. You must be invited to join this hub.');
                    }
                    else {
                        LOG::debug('CommunityPermissionMiddleware: User is not logged in and this community is closed, redirecting to login page');
                        return view('auth/login')->withError('This hub is closed. Please request to become a member.');
                    }
                }
            }
            else { // This group is not restricted, ie open or closed
                return $next($request);
                if (Auth::check()) {
                    if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
                        LOG::debug('CommunityPermissionMiddleware: This user is a member of this open Share');
                        return $next($request);
                    }
                    else {
                        LOG::debug('CommunityPermissionMiddleware: Open hub but user is not a member, path = ('.$request->path().') ('."users/".Auth::user()->id.")");

                        if ($request->path() == "/" || $request->path() == "entry/json.browse" || $request->path() == "users/".Auth::user()->id ) {
                            // we let people see some pages of an open share
                            return $next($request);
                        }
                        
                        // lets ask the user whether they would like to join this share
                        return view('join-open', ['error'=>'you are not a member of ', 'name' => $request->whitelabel_group->name] );
                    }
                }
                else {
                    LOG::debug('CommunityPermissionMiddleware: open hub and user not logged in');
                }

            }
        }

        return $next($request);
    }
}