<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\Community;
use App\Http\Transformers\CommunityTransformer;
use App\Http\Transformers\MemberlistTransformer;

class CommunitiesController extends ApiGuardController
{

  protected $apiMethods = [
      'all' => [
          'keyAuthentication' => false
      ],
      'show' => [
          'keyAuthentication' => false
      ],
      'memberlist' => [
          'keyAuthentication' => false
      ],
  ];


    public function all()
    {
        $communities = Community::with('members')->paginate(20);
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

    public function memberlist($id)
    {
        try {

            $members = Community::find($id)->members;
            return $this->response->withCollection($members, new MemberlistTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();

        }
    }

}
