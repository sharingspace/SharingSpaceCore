<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;
use Illuminate\Http\Response;

class EntryEdit
{
   /**
     * Handle an incoming request and checks whether a user can edit an entry.
     * A user can edit an entry, if:
     * i) they are logged in and owner of entry
     * ii) they are logged  and super admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Is user a member of this community, if not they cannot create an entry ?
        if (Auth::check()) {

            $entry = \App\Models\Entry::find($request->entryID);

            if ($entry) {
               
                if ($entry->created_by == Auth::user()->id || Auth::user()->isAdminOfCommunity($request->whitelabel_group)) {
                    //log::debug('editEntry middleware:: User is allowed to edit entry');

                    return $next($request);
                }
                else {

                    //log::debug('editEntry middleware:: entry does not belong to user');
                    $request->session()->flash('error', trans('general.entries.messages.not_allowed'));
                }
            }
            else {
                //log::debug('editEntry middleware:: invalid entry');
                $request->session()->flash('error', trans('general.entries.messages.invalid'));
            } 
        }
        else {
            //log::debug('editEntry middleware:: user is not logged in');
            $request->session()->flash('error', trans('general.entries.sign_in_edit'));
        }

        return response(view('home'));
    }
}
