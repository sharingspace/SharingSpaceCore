<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use App\Entry;
use Input;
use Validator;
use Redirect;

class CommunitiesController extends Controller
{

  public function getHomepage()
  {

    if (Auth::check()) {
        // The user is logged in...
        $user = Auth::user();
        return view('home')->with('user',$user);
    }
    return view('home');

  }


  /*
  Get the entries view in current community
  */
  public function getEntriesView()
  {
    return view('browse');
  }



  /*
  Get the members in current community
  */
  public function getMembers(Request $request)
  {
    $members = $request->whitelabel_group->members()->get();
    return view('members')->with('members',$members);
  }

  /*
  Get the create community page
  */
  public function getCreate()
  {
    return view('communities.edit');
  }


  /*
  * Save new community
  */
  public function postCreate(Request $request)
  {
    $community = new \App\Community();

    $validator = Validator::make(Input::all(), $community->rules);

    if ($validator->fails()) {
      return Redirect::back()->withInput()->withErrors($validator->messages());
    } else {

      $community->name	= e(Input::get('name'));
      $community->subdomain	= e(Input::get('subdomain'));

      if ($community->save()) {
        return redirect('/')->with('success','Success!');

      }

    }

  }



}
