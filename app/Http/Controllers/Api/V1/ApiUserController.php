<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;
use Helper;
use Laravel\Passport\Client;
use GuzzleHttp\Client as GuzzleHttp;
use \App\Http\Transformers\GlobalTransformer;


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
            return Helper::sendResponse(false, $validator->errors(), []);        
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

        return Helper::sendResponse(true, '', $transform);
    }

    public function leaveCommunity(Request $request, $community_id) {
    	if ($community_id) {
            $community = auth('api')->user()->communities()->where('community_id', $community_id)->first();
           
            if (isset($community)) {
                if (auth('api')->user()->communities()->detach($community->id)) {
                	return Helper::sendResponse(true, 'You have left the Share, "'.$community->name.'"');
                }
                else {
                	return Helper::sendResponse(false, 'Unable to leave the Share, "'.$community->name.'"');
                }
            }
        }
    }

}