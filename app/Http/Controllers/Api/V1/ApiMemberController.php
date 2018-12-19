<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;
use Helper;
use \App\Http\Transformers\GlobalTransformer;



class ApiMemberController extends Controller
{
    /*-------------------------------------------------------------------  
     * Old Apis (We will delete later)
     ------------------------------------------------------------------*/

    public function show(Request $request, $member_id){
        $jwt = (new \Lcobucci\JWT\Parser())->parse($request->bearerToken());
        $community_id = $jwt->getClaim('community')->community_id;

        try {
            $member = Community::findOrFail($community_id)->members()->where('users.id','=',$member_id)->paginate(1);
            $trnsform = new UserTransformer;
            // return response()->json($trnsform->transform($member));
          //  return $this->response->withItem($member, new UserTransformer);

        } catch (ModelNotFoundException $e) {
            //return $this->response->errorNotFound();
            return Helper::sendResponse(502, 'Something went wrong');

        }
        return Helper::sendResponse(200, '', $trnsform->transform($member));

    }

    public function all(Request $request){
        $jwt = (new \Lcobucci\JWT\Parser())->parse($request->bearerToken());
        $community_id = $jwt->getClaim('community')->community_id;

        if ($request->has('per_page')) {
            $per_page = $request->input('per_page');
        } else {
            $per_page = 20;
        }

        try {

            $members = Community::findOrFail($community_id)->members()->orderBy('created_at','desc')->paginate($per_page);
            $trnsform = new UserTransformer;
            // return response()->json($trnsform->transform($members));

        } catch (Exception $e) {
            return Helper::sendResponse(502, 'Something went wrong');

        }
        return Helper::sendResponse(200, '', $trnsform->transform($members));
        
    }


    /*-------------------------------------------------------------------  
     * NEW Apis STARTING POINT
     ------------------------------------------------------------------*/

    /*
     * Get all permissions assosiated with the authenticated member
     */

    public function getAllMemberPermissions(Request $request, $community_id) {
        
        $user = auth('api')->user();

        $community = Helper::getCommunity($community_id);
        
        if ($user->isAdminOfCommunity($community)) {
            return Helper::sendResponse(200, '', ['is_super_admin'=>true]);
        }
        return Helper::sendResponse(200, '', $user->permissions);
    }

    /*
     * Get all members for single sharing space
     * Improvement: later need to add the role per member
     * Improvement: later need to add pagination
     */
    public function getMembers(Request $request,$community_id) {

        $community = Helper::getCommunity($community_id);
    
        if ($request->has('per_page')) {
            $per_page = $request->input('per_page');
        } else {
            $per_page = 20;
        }

        $members = $community->members()->orderBy('created_at','desc')->paginate($per_page);
        $trnsform = GlobalTransformer::transformall_members($members, $community_id);
        return Helper::sendResponse(200, '', $trnsform);
    }


    /* 
     * Assign Single role to member.
     */
    public function assignRoletoMember() {
        
    }

}
