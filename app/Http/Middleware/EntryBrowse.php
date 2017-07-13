<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class EntryBrowse
{
  /**
   * Handle an incoming request to view the entries 
   * on the homepage.
   * We allow anyone to see an open or closed homepage,
   * whether or not they are logged in. We do not allow
   * someone to see the homepage of a secret share unless
   * they are a logged in member of that share
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    // This is a whitelabel group, otherwise skip it
    if ($request->whitelabel_group) {
      //log::debug('EntryBrowse middleware: This is a valid whitelabel share');
      if ($request->whitelabel_group->group_type == 'S') {
        //log::debug('EntryBrowse middleware: This is a secret share');

        // If the user is logged in, check that they are a member and are allowed to see this group
        if (Auth::check()) {
          //log::debug('EntryBrowse middleware: User is logged in');
          if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
            //log::debug('EntryBrowse middleware: This user is authorized to see this community');
            return $next($request);
          }
          else {
            //log::debug('EntryBrowse middleware: Hub is secret but user is not a member');
            $request->session()->flash('error', trans('general.community.invite_secret'));
            return response(view('home'));    
          }
        }
        else { // User is not logged in and this is a secret share, redirect to login page
          //log::debug('EntryBrowse: User is not looged in and this is a secret share');

          $request->session()->flash('error', trans('general.community.sign_in_secret'));
          return response(view('home'));    
        }
      
      }
    }
    return $next($request);
  }
}
