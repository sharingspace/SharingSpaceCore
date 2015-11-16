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

    $entries = $request->whitelabel_group->entries()->with('author','exchangeTypesNames')->get();

    if (Auth::check()) {
        // The user is logged in...
        $user = Auth::user();
        return view('home')->with('user',$user)->with('entries',$entries);
    }

    return view('home')->with('entries',$entries);

  }

}
