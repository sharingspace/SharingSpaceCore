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

class MemberPermissionMiddleware
{
  /**
   * Handle an incoming request
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  { 
    // This is a whitelabel group, otherwise skip it
    if ($request->whitelabel_group) {
      if ($request->whitelabel_group->group_type == 'O') {
        return $next($request);
      }
      else if (!Auth::check()) { 
        // closed or secret, if they aren't logged they can't see a profile
        return back()->with('error', trans('general.user.login_to_view'));
      }
      else {
        // user is logged in
        if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
          //log::debug('MemberPermissionMiddleware: This user is authorized to see members as they are a member of this Share');
          return $next($request);

        }
        else {
          //log::debug('MemberPermissionMiddleware: user is not a member of closed share'.trans('general.user.join_to_view'));

          return back()->with('error', trans('general.user.join_to_view'));
        }
      }
    }

    return $next($request);
  }
}