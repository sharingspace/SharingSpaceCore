<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use Log;

class PagesController extends Controller
{

    public function getHomepage(Request $request, $hp=null)
    {

        if ($request->whitelabel_group) {
            LOG::debug('Whitelabel routing: Passed middleware, start getHomepage');
            if (Auth::check()) {
                if (Auth::user()->canSeeCommunity($request->whitelabel_group)) {
                    LOG::debug('Whitelabel routing: User can see this homepage');
                    $entries = $request->whitelabel_group->entries()->with('author', 'exchangeTypes', 'media')->orderBy('created_at', 'desc')->get();
                    return view('home')->with('entries', $entries);
                } else {
                    LOG::debug('Whitelabel routing: User is logged in but cannot see this homepage');
                    return redirect()->route('community.request-access.form')->withError('You must be a member of this group to view this page.');
                }


            } else {
                if ($request->whitelabel_group->group_type == 'S') {
                    return view('auth/login-unbranded')->withError('You must be logged in and a member to see this.');
                } else {
                    return view('auth/login')->withError('You must be logged in and a member to see this.');
                }

            }



        } else {
            $communities = \App\Community::orderBy('created_at', 'DESC')->IsPublic()->take(20)->get();
            return view('home'.$hp)->with('communities', $communities);
        }

    }

}
