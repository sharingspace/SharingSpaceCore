<?php
/**
 * This Middleware does a high-level check to see whether
 * or not a user can create an entry.
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

class EntryPermissionMiddleware
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
        // Is user a member of this community, if not they cannot create an entry ?
        if (Auth::check()) {
            if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
                //log::debug('EntryPermissionMiddleware: User is allowed to edit and create enties');

                return $next($request);
            }
            else {
                //log::debug('EntryPermissionMiddleware: User is not allowed to create enties: '.$request->whitelabel_group->name);
                
                return view('request-access')->with('groupName', ucfirst($request->whitelabel_group->name))->withError('You must be a member of this Share to create an entry.');
            }
        }
        else {
            //log::debug('EntryPermissionMiddleware: User is not logged in');
            return back()->with('error', 'Profile updated!');
        }

        return $next($request);
    }
}
