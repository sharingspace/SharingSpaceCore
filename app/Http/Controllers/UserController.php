<?php
/**
 * This controller handles all actions related to Users for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use Auth;
use Input;
use Redirect;
use Helper;

class UserController extends Controller
{
    /**
    * Returns a vew that shows the user their account dashboard
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return View
    */
    public function getDashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('home')->with('user', $user);
        }

    }

    /**
    * Returns a view tha displays subscription charge history
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return View
    */
    public function getHistory()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions;
        return view('account.history')->with('subscriptions', $subscriptions);
    }


    /**
    * Returns a form that allows the user to update their settings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    UsersController::postSettings()
    * @since  [v1.0]
    * @return View
    */
    public function getSettings()
    {
        return view('account.settings');
    }


    /**
    * Validates and stores the users updated general settings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    UsersController::getSettings()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postSettings()
    {

        if ($user = User::find(Auth::user()->id)) {

            $user->first_name = e(Input::get('first_name'));
            $user->last_name = e(Input::get('last_name'));
            $user->email = e(Input::get('email'));
            $user->display_name = e(Input::get('display_name'));
            $user->website = e(Input::get('website'));
            $user->bio = e(Input::get('bio'));
            $user->location = e(Input::get('location'));

            if (Input::get('location')) {
                $latlong = Helper::latlong(Input::get('location'));
            }

            if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
                $user->latitude         = $latlong['lat'];
                $user->longitude         = $latlong['lng'];
            }


            if (!$user->save()) {
                return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
            }

            return redirect()->route('user.settings.view')->with('success', 'Saved!');

        }

        // That user wasn't valid
        return redirect()->route('user.settings.view')->withInput()->with('error', 'Invalid user');

    }

    /**
    * Validates and stores the users social settings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    UsersController::getSettings()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postUpdateSocial()
    {

        if ($user = User::find(Auth::user()->id)) {

            $user->fb_url = e(Input::get('fb_url'));
            $user->twitter = e(Input::get('twitter'));
            $user->google = e(Input::get('google'));
            $user->pinterest = e(Input::get('pinterest'));
            $user->youtube = e(Input::get('youtube'));

            if (!$user->save()) {
                return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
            }

            return redirect()->route('user.settings.view')->with('success', 'Saved!');

        }

        // That user wasn't valid
        return redirect()->route('user.settings.view')->withInput()->with('error', 'Invalid user');

    }

    /**
    * Validates and stores the users updated password.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    UsersController::getSettings()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postUpdatePassword()
    {

        if ($user = User::find(Auth::user()->id)) {

            $user->password = e(Input::get('password'));

            if (!$user->save()) {
                return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
            }

            return redirect()->route('user.settings.view')->with('success', 'Saved!');

        }

        // That user wasn't valid
        return redirect()->route('user.settings.view')->withInput()->with('error', 'Invalid user');

    }


    /**
    * Validates and stores the users updated notification settings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    UsersController::getSettings()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postUpdateNotifications()
    {

        if ($user = User::find(Auth::user()->id)) {

            if (!$user->save()) {
                return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
            }

            return redirect()->route('user.settings.view')->with('success', 'Saved!');

        }

        // That user wasn't valid
        return redirect()->route('user.settings.view')->withInput()->with('error', 'Invalid user');

    }

    /**
    * Validates and stores the users updated privacy settings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    UsersController::getSettings()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postUpdatePrivacy()
    {
        return "postUpdatePrivacy() needs to be implemented and needs db updates";
        if ($user = User::find(Auth::user()->id)) {

            if (!$user->save()) {
                return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
            }

            return redirect()->route('user.settings.view')->with('success', 'Saved!');

        }

        // That user wasn't valid
        return redirect()->route('user.settings.view')->withInput()->with('error', 'Invalid user');
    }


    /**
    * Returns a view that displays the user's public profile.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return Redirect
    */
    public function getProfile($id)
    {
        if ($user = User::findOrFail($id)) {
            return view('users.view')->with('user', $user);
        } else {
            echo 'Invalid user';
        }

    }


    /**
    * Joins a user to a community
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param $request
    * @since  [v1.0]
    * @return View
    */
    public function postJoinCommunity(Request $request)
    {
        $user = Auth::user();
        if ($user->communities()->sync([$request->whitelabel_group->id])) {
            return redirect()->route('browse')->withInput()->with('success', 'You have joined this community!');
        } else {
            return redirect()->route('browse')->withInput()->with('error', 'Unable to join community');
        }

    }
}
