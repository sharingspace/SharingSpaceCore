<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;
use Input;
use Validator;
use Helper;
use Laravel\Passport\Client;
use GuzzleHttp\Client as GuzzleHttp;
use \App\Http\Transformers\GlobalTransformer;
use Log;

class ApiUserController extends Controller
{

	/*---------------------------------------------------------------------
	 * Frontend Apis 
	 --------------------------------------------------------------------*/

    public function postregisterUser(Request $request) {

        $validator = \Validator::make($request->all(), [
            'display_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'terms_and_conditions' => 'accepted',
        ]);

        if ($validator->fails()) { 
            return Helper::sendResponse(422, $validator->errors(), []);        
        }

        $request['email'] = trim($request['email']);
	      $user =  User::create([
	          'display_name' => $request['display_name'],
	          'email' => $request['email'],
	          'password' => bcrypt($request['password']),
	      ]);
        
        $client = Client::where('password_client', 1)->first();
        $http = new GuzzleHttp;	
        $response = $http->post(url('oauth/token'), [
		    'form_params' => [
		    'grant_type'    => 'password',
	        'client_id'     => $client->id,
	        'client_secret' => $client->secret,
	        'username'      => $request->email,
	        'password'      => $request->password,
	        'scope'         => null,
		    ],
		]);
        return json_decode((string) $response->getBody(), true);
    }

     /*---------------------------------------------------------------------
	 * Backend Apis 
	 --------------------------------------------------------------------*/

     /*
      * Get All Community of authenticated user
      * Improvement: later need to add pagination
      */
    public function getAllCommunities(Request $request) {
        
        $user = auth('api')->user();
        $communities = $user->communities()->paginate(20);
        $transform = GlobalTransformer::transform_allcommunities($communities);

        return Helper::sendResponse(200, '', $transform);
    }

    /*
     * Leave a community
     */
    public function leaveCommunity(Request $request, $community_id) {
    	if ($community_id) {
            $community = auth('api')->user()->communities()->where('community_id', $community_id)->first();
           
            if (isset($community)) {
                if (auth('api')->user()->communities()->detach($community->id)) {
                	return Helper::sendResponse(200, 'You have left the Share, "'.$community->name.'"');
                }
                else {
                	return Helper::sendResponse(502, 'Unable to leave the Share, "'.$community->name.'"');
                }
            }
            return Helper::sendResponse(404, 'Unable to find this community, "'.$community->name.'"');
        }
    }

 /*-------------------------------------------------------------------------------
  * User Profile methods
  *-------------------------------------------------------------------------------/    

    /*
     * Profile info save
     */
    public function updateProfile(Request $request, $community_id){

        if ($user = User::find(auth('api')->user()->id)) {

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
                // return $user->getErrors();
                return Helper::sendResponse(502, $user->getErrors());
            }
            return Helper::sendResponse(200, 'Saved!');
        }

        return Helper::sendResponse(404, 'Invalid user');
    }

    /*
     * Social info save
     */
    public function updateSocial(Request $request, $community_id){

        if ($user = User::find(auth('api')->user()->id)) {

            $user->fb_url = $request->fb_url;
            $user->twitter = $request->twitter;
            $user->google = $request->google;
            $user->pinterest = $request->pinterest;
            $user->youtube = $request->youtube;

            if (!$user->save()) {
                return Helper::sendResponse(502,  $user->getErrors());
            }
            return Helper::sendResponse(200,  trans('general.user.social_success'));
        }
        return Helper::sendResponse(404, trans('general.user.social_failure'));
    }

    /*
     * Avtar info save
     */
    public function updateAvatar(Request $request, $community_id){
        if ($user = User::find(auth('api')->user()->id)) {            
            if (Input::hasFile('avatar_img')) {
                LOG::debug("postUpdateAvatar: have image, preparing to upload");
                $user->uploadImage($user, Input::file('avatar_img'), 'users');
                LOG::debug("postUpdateAvatar: upload complete");
                return Helper::sendResponse(200, trans('general.user.avatar_success'));
            }
            else if(Input::get('delete_img')) {
                if (User::deleteAvatar($user->id)) {
                    return Helper::sendResponse(200, 'delete okay');
                }
                else {
                    return Helper::sendResponse(502, 'delete fail');
                }
            }
            return Helper::sendResponse(200, 'Your changes successfully saved');
        }
        else {

            // That user wasn't valid
            // LOG::debug("postUpdateAvatar: invalid user");
            return Helper::sendResponse(404, trans('general.user.avatar_failure'));
        }
    }

    /*
     * Profile info save
     */
    public function ChangePassword(Request $request, $community_id){
        if ($user = User::find(auth('api')->user()->id)) {

            $user->password = \Hash::make(e(Input::get('password')));

            if (!$user->save()) {
                // return $user->getErrors();
                return Helper::sendResponse(502, $user->getErrors());
            }

            return Helper::sendResponse(200, 'Saved!');

        }
        return Helper::sendResponse(404, 'Invalid user');
    }
}