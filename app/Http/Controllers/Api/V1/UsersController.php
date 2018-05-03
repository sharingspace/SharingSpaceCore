<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;


class UsersController extends Controller
{


    public function show(Request $request, $id)
    {

        try {
            $member = Community::findOrFail($request->id)->members()->where('users.id','=',$id)->paginate(1);
            $trnsform = new UserTransformer;
            return response()->json($trnsform->transform($member));
          //  return $this->response->withItem($member, new UserTransformer);

        } catch (ModelNotFoundException $e) {
            //return $this->response->errorNotFound();
        }
    }


    public function all(Request $request)
    {
        if ($request->has('per_page')) {
            $per_page = $request->input('per_page');
        } else {
            $per_page = 20;
        }

        try {

            $members = Community::findOrFail($request->id)->members()->orderBy('created_at','desc')->paginate($per_page);
            //return $this->response->withItem($members, new UserTransformer);
            $trnsform = new UserTransformer;
            return response()->json($trnsform->transform($members));

        } catch (ModelNotFoundException $e) {
           //return $this->response->errorNotFound();

        }
    }


}
