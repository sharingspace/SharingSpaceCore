<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;
use Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['email'] = trim($data['email']);
        return Validator::make($data, [
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
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
      $data['email'] = trim($data['email']);
      return User::create([
          'display_name' => $data['display_name'],
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
      ]);
    }
    
  public function showRegistrationForm(Request $request)
  {
    if (isset($request->whitelabel_group) && $request->whitelabel_group->subdomain) {
      return view('auth.register')->with('subdomain', $request->whitelabel_group->subdomain)->with('shareName', $request->whitelabel_group->name);
    }
    else {
      return view('auth.register');
    }
  }

  protected function registered(Request $request, $user)
  {
    if (isset($request->whitelabel_group) && $request->whitelabel_group->subdomain) {
      // if this is an open share, join them
      if ($request->whitelabel_group->isOpen()) {
        if (Auth::user()->communities()->sync([$request->whitelabel_group->id])) {
          //LOG::debug("registered: joined open share successfully");
        }
        else {
          //LOG::debug("registered: error joining open share");
          return redirect()->route('home')->withInput()->with('error', 'Unable to join '.$request->whitelabel_group->name);
        }
      }
      else if ($request->whitelabel_group->isClosed()) {
        $user = Auth::user();
        if ($user) {
            // find out whether they have already asked to join this share
            $request_count = $request->whitelabel_group->getRequestCount($user->id);

            //LOG::debug("getRequestAccess: request_count = ".$request_count);
            return view('request-access', ['request_count'=>$request_count,'name'=>$request->whitelabel_group->name]);
        }
        else {
            // not logged in so send them to the signup page
            //LOG::debug("getRequestAccess: user is not logged in so redirect them");
            return view('request-access', ['request_count'=>$request_count,'name'=>$request->whitelabel_group->name]);
        }
      }
    }
    else {
      //LOG::debug("registered: error joining open share"); 
      return redirect()->route('home')->withInput()->with('success', trans('general.community.account_great'));
    }
  }
}
