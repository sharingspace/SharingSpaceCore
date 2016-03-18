<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;

class PagesController extends Controller
{

  public function getHomepage(Request $request)
  {

    if ($request->whitelabel_group) {
        if (Auth::check()) {
            if (Auth::user()->canSeeCommunity($request->whitelabel_group)) {
                $entries = $request->whitelabel_group->entries()->with('author','exchangeTypes','media')->orderBy('created_at','desc')->get();
                return view('home')->with('entries',$entries);
            } else {
                return view('request-access');
            }

        }


    } else {
      $communities = \App\Community::orderBy('created_at','DESC')->IsPublic()->take(20)->get();
      return view('home')->with('communities',$communities);
    }

  }

}
