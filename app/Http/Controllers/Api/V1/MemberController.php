<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;


class MemberController extends Controller
{

    public function show($community_id, $member_id)
    {

        try {
            $member = Community::findOrFail($community_id)->members()->where('users.id','=',$member_id)->paginate(1);
            $trnsform = new UserTransformer;
            return response()->json($trnsform->transform($member));
          //  return $this->response->withItem($member, new UserTransformer);

        } catch (ModelNotFoundException $e) {
            //return $this->response->errorNotFound();
        }
    }

    public function all(Request $request, $community_id)
    {

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


}
