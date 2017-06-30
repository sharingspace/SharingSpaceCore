<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class EntryView
{
    /**
     * Handle an incoming request and checks whether a user can view an entry.
     * A user can view an entry, if:
     * i) the share is open (logged in or not)
     * ii) the share is closed and user is a member of share

     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check that the entry exists
        $entry = \App\Models\Entry::find($request->entryID);
        if (!$entry) {
            $request->session()->flash('error', trans('general.entries.messages.invalid'));

            return response(view('home'));
        }

        // entries are always visible on open shares
        if ($request->whitelabel_group->group_type != 'O') {
            // closed or secret, if they aren't logged in throw them out now
            if (!Auth::check()) {
                $request->session()->flash('error', trans('general.entries.messages.view_not_allowed_login'));
                return back();
            }
            else if (Auth::user()->isMemberOfCommunity($request->whitelabel_group)) {
                //log::debug('EntryView: User is logged in and a member');

                return $next($request);
            }
            else {
                //log::debug('EntryView: User is not logged in and this is not an Open Share');

                $request->session()->flash('error', trans('general.entries.messages.view_not_allowed_join'));
                return back();
            }
        }                

        //log::debug('EntryView Middleware: entry can be viewed');

        return $next($request);
    }
}
