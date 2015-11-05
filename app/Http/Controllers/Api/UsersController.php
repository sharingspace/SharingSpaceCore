<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\User;
use App\Http\Transformers\UserTransformer;

class UsersController extends ApiGuardController
{

  protected $apiMethods = [
      'all' => [
          'keyAuthentication' => false
      ],
      'show' => [
          'keyAuthentication' => false
      ],
  ];

  public function all()
  {
      $users = User::get();
      return $this->response->withCollection($users, new \App\Http\Transformers\UserTransformer);
  }


  public function show()
  {
      $user = User::findOrFail($id);
      return $this->response->withCollection($user, new \App\Http\Transformers\UserTransformer);
  }


}
