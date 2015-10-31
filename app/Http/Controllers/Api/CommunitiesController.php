<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\Community;
use App\Http\Transformers\CommunityTransformer;

class CommunitiesController extends ApiGuardController
{

    public function all()
    {
        $communities = Community::with('members')->get();
        return $this->response->withCollection($communities, new CommunityTransformer);
    }

    public function show($id)
    {
        try {

            $community = Community::findOrFail($id);
            return $this->response->withItem($community, new CommunityTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();

        }
    }


}
