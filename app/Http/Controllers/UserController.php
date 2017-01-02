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
use App\User;
use Auth;
use Input;
use Redirect;
use Helper;
use App\Message;
use Mail;
use Log;

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

            return redirect()->route('user.settings.view')->with('success', trans('general.user.social_success'));
        }

        // Damn, that user was an imposter!
        return redirect()->route('user.settings.view')->withInput()->with('error', trans('general.user.social_failure'));
    }

    /**
    * Stores the users avatar.
    *
    * @author [D. Linanrd] [<david@linnard.com>]
    * @see    UsersController::getSettings()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postUpdateAvatar()
    {
        if ($user = User::find(Auth::user()->id)) {
            if (Input::hasFile('avatar_img')) {
                LOG::debug("postUpdateAvatar: have image, preparing to upload");
                $user->uploadImage($user, Input::file('avatar_img'), 'users');
                LOG::debug("postUpdateAvatar: upload complete");
                return redirect()->route('user.settings.view')->with('success', trans('general.user.avatar_success'));
            }
            else if(Input::get('delete_img')) {
                if (User::deleteAvatar($user->id)) {
                    return redirect()->route('user.settings.view')->with('success', 'delete okay');
                }
                else {
                    return redirect()->route('user.settings.view')->with('success', 'delete fail');
                }
            }
        }
        else {
            // That user wasn't valid
            LOG::debug("postUpdateAvatar: invalid user");

            return redirect()->route('user.settings.view')->withInput()->with('error', trans('general.user.avatar_failure'));
        }
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
    * Accepts a user to sharing community, sends user an email and updates community request table
    *
    * @author [D. Linnard] [<dslinnard@yahoo.com>]
    * @since  [v1.0]
    * @return Redirect
    */
    public function getAcceptUser(Request $request)
    {
        if ($user = User::findOrFail(Input::get('user_id'))) {

            if ($user->communities()->sync([$request->whitelabel_group->id])) {
                // mark user as accepted
                $request->whitelabel_group->acceptUser(Auth::user()->id, Input::get('user_id'), $request->whitelabel_group->id);

                // send an email to the user letting them know
                $data['uc_subdomain'] = ucfirst($request->whitelabel_group->name);
                $data['subdomain'] = $request->whitelabel_group->name;
                $data['name'] = $user->display_name;
                $data['subject'] = 'Welcome to the '.$data['uc_subdomain']. ' Share!';
                $data['to_email'] = $user->email;
                //LOG::debug('getAcceptUser: email to be sent to = '.$user->email.'  '.Input::get('user_id'));
                if (!empty($request->whitelabel_group->logo)) {
                    if( config('app.debug')) {
                        // this is for testing only
                        $data['logo'] = 'https://anyshare.coop/assets/img/hp/anyshare-logo-web-retina.png';
                    }
                    else {
                        $data['logo'] = public_path()."/assets/uploads/community-logos/".$request->whitelabel_group->id."/".$request->whitelabel_group->logo;
                    }
                }

                Mail::send(['text' => 'emails.acceptedText', 'html' => 'emails.acceptedHTML'], $data,
                    function ($message) use ($data) {
                        $message->to($data['to_email'], $data['name'])->subject($data['subject']);
                    }
                );

                return response()->json(['success'=>true, 'alert_class' => 'success', 'message'=>e(Input::get('displayName')). ' has joined '.ucfirst($request->whitelabel_group->name).'!', 'user_id'=>Input::get('user_id')]);
            }
            else {
                return redirect()->route('home')->withInput()->with('error', 'Unable to join website');
            }
        }
        else {
            return redirect()->route('home')->withInput()->with('error', 'user not found');
        }
    }


   /**
    * Marks a pending user to sharing community as rejected
    *
    * @author [D. Linnard] [<dslinnard@yahoo.com>]
    * @since  [v1.0]
    * @return json response
    */
    public function getRejectUser(Request $request)
    {
        $request->whitelabel_group->rejectUser(Auth::user()->id, Input::get('user_id'), $request->whitelabel_group->id);
        return response()->json(['success'=>true, 'alert_class' => 'warning', 'message'=>e(Input::get('displayName')).' has been declined from '.ucfirst($request->whitelabel_group->name), 'user_id'=>Input::get('user_id')]);
    }


    /**
    * Joins a user to a community
    *
    * @todo Change this to a post request
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param $request
    * @since  [v1.0]
    * @return Redirect
    */
    public function getJoinCommunity(Request $request)
    {
        //LOG::debug('getJoinCommunity: entered');
        if ($request->whitelabel_group->isOpen()) {
            if (Auth::user()->communities()->sync([$request->whitelabel_group->id])) {
                LOG::debug("getJoinCommunity: joined open share successfully");

                return redirect()->route('home')->withInput()->with('success', 'You have joined '.ucfirst($request->whitelabel_group->name).'!');
            } else {
                LOG::debug("getJoinCommunity: error joining open share");

                return redirect()->route('home')->withInput()->with('error', 'Unable to join '.$request->whitelabel_group->name);
            }
        }
        else {
            LOG::debug("getJoinCommunity: share is closed");
            return view('request-access', ['error'=>'closed', 'name' => $request->whitelabel_group->name] );
        }
    }


    /**
    * Leaves a community
    *
    * @todo Change this to a post request
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param $request
    * @since  [v1.0]
    * @return Redirect
    */
    public function getLeaveCommunity(Request $request)
    {
        if (Auth::user()->communities()->detach([$request->whitelabel_group->id])) {
            return redirect()->route('home')->withInput()->with('success', 'You have left this website!');
        } else {
            return redirect()->route('home')->withInput()->with('error', 'Unable to leave website');
        }
    }


    /**
    * Gets the list of communities a user is a member of
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param $request
    * @since  [v1.0]
    * @return View
    */
    public function getCommunityMemberships(Request $request)
    {
        $communities = Auth::user()->communities()->get();
        return view('account.community_memberships')->with('communities',$communities);

    }

}
