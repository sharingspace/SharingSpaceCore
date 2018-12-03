<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;


class MemberController extends Controller
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
            return response()->json($trnsform->transform($member));
          //  return $this->response->withItem($member, new UserTransformer);

        } catch (ModelNotFoundException $e) {
            //return $this->response->errorNotFound();
        }
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
            return response()->json($trnsform->transform($members));

        } catch (Exception $e) {

        }
    }


    /*-------------------------------------------------------------------  
     * NEW Apis STARTING POINT
     ------------------------------------------------------------------*/

    /*
     * Get all permissions assosiated with the authenticated member
     */

    public function getAllMemberPermissions(Request $request, $community_id) {
        
        $user = auth('api')->user();

        $community = getCommunity($community_id);
        
        if ($user->isAdminOfCommunity($community)) {
            return $this->sendResponse(true, '', ['is_super_admin'=>true]);
        }
        return $this->sendResponse(true, '', $user->permissions);
    }

    /*
     * Get all members for single sharing space
     * Improvement: later need to add the role per member
     * Improvement: later need to add pagination
     */
    public function getMembers($community_id) {

        $community = getCommunity($community_id);
        $members = $community->members()->get();
        return $this->sendResponse(true, '', $members);
    }


    /* 
     * Assign Single role to member.
     */
    public function assignRoletoMember() {
        
    }


}
