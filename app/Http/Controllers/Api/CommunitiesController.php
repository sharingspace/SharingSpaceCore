<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\Models\Community;
use App\Http\Transformers\UserTransformer;

class CommunitiesController extends ApiGuardController
{

    protected $apiMethods =
        [

            'show' => [
                'keyAuthentication' => false
            ],
            'members' => [
                'keyAuthentication' => false
            ],
            'slackShowMembers' => [
                'keyAuthentication' => false
            ],

    ];



}
