<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Community;
use Socialite;
use Auth;
use Config;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Log;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getRegister(Request $request)
    {
        log::debug("getRegister: entered");

        if ($request->whitelabel_group->subdomain) {
            log::debug("getRegister: subdomain = ".$request->whitelabel_group->subdomain);

            return view('auth.register')->with('subdomain', $request->whitelabel_group->subdomain)->with('share', $request->whitelabel_group->name);
        }
        
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
      log::debug("postRegister: entered");

      // call the RegistersUsers::postRegister method
      // hold onto the return value for later
      $redirect = $this->register($request);

      $user = $request->user();
      if ($user) {
        if (Input::get('subdomain')) {

          LOG::debug('postRegister: entered >>>>>>>>>>>>>>>>>>>>>>>'. Input::get('subdomain'));

          return redirect()->route('join-community', ['subdomain'=>Input::get('subdomain')]);
        }
        LOG::debug('postRegister: no subdomain');

        return Redirect::back()->with('success', "You have successfully created an Anyshare account");
      }
      else {
        return Redirect::back()->with('error',  "Sorry, something went wrong creating your Anyshare account");
      }
    }


    /**
     * Redirect the user to the OAuth authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request, $provider)
    {
        if ($request->whitelabel_group) {
            $request->session()->put('auth_subdomain', $request->whitelabel_group->subdomain);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {

        if ($request->session()->has('auth_subdomain')) {
            $subdomain = $request->session()->get('auth_subdomain');
            $request->session()->forget('auth_subdomain');
            $redirect = 'https://'.$subdomain.'.'.config('app.domain');
        } else {
            $redirect = config('app.url');
        }
        try {

            $user = Socialite::driver($provider)->user();

            if ($getUser = User::checkForSocialLoginDBRecord($user, $provider)) {
                Auth::login($getUser);
                return redirect($redirect)->with('success', 'You have been logged in!');
            } else {
                $newUser = User::saveSocialAccount($user, $provider);
                Auth::login($newUser);
                return redirect($redirect)->with('success', 'Welcome aboard!');
            }

        } catch (Exception $e) {
            return redirect($redirect)->with('error', 'We couldn\'t log you in :(');
        }



    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
            'display_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'terms_and_conditions' => 'accepted',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create(
            [
            'display_name' => $data['display_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]
        );
    }
}
