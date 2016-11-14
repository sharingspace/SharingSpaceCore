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
      if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
        //LOG::debug('MemberPermissionMiddleware: This user is authorized to see this open hub');
        return $next($request);
      }
      else {
        //LOG::debug('MemberPermissionMiddleware: Open hub but user is not a member');
        if ($request->path() == "users/".Auth::user()->id) {
          // let them see their own profile
          return $next($request);
        }

        return view('join-open', ['error'=>'You are not a member of ', 'name' => $request->whitelabel_group->name] );
      }
    }

    return $next($request);
  }
}