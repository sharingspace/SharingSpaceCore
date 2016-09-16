<?php
namespace App\Http\Controllers\Api;

use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\Community;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;


class UsersController extends ApiGuardController
{


    public function show(Request $request, $id)
    {

        try {
            $member = Community::findOrFail($request->whitelabel_group->id)->members()->where('users.id','=',$id)->paginate(1);
            return $this->response->withItem($member, new UserTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();
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

            $members = Community::findOrFail($request->whitelabel_group->id)->members()->orderBy('created_at','desc')->paginate($per_page);
            return $this->response->withItem($members, new UserTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();

        }
    }


}
