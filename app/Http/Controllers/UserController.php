<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Input;
use Redirect;


class UserController extends Controller
{
    public function getDashboard()
    {
        if (Auth::check()) {
            // The user is logged in...
            $user = Auth::user();
            return view('home')->with('user',$user);
        }

    }

    public function getSettings()
    {
      return view('account.settings');
    }

    /*
    * Save the user's updated settings
    *
    */
    public function postSettings()
    {
      $user = \App\User::find(Auth::user()->id);

      $user->first_name = e(Input::get('first_name'));
      $user->last_name = e(Input::get('last_name'));
      $user->display_name = e(Input::get('display_name'));
      $user->website = e(Input::get('website'));
      $user->bio = e(Input::get('bio'));

      if ($user->save()) {
         return Redirect::route('user.settings.view')->with('success','Success!');
      } else {
        return view('account.settings')->with('error','Success!');
      }

    }


    public function getProfile($id)
    {
        if ($user = \App\User::findOrFail($id)) {
          return view('users.view')->with('user',$user);
        } else {
          echo 'Invalid user';
        }

    }

}
