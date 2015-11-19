<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;

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


    public function getProfile($id)
    {
        if ($user = \App\User::findOrFail($id)) {
          return view('users.view')->with('user',$user);
        } else {
          echo 'Invalid user';
        }

    }

}
