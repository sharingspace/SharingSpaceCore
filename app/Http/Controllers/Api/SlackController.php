<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\Community;
use App\Http\Transformers\CommunityTransformer;
use App\Http\Transformers\MemberlistTransformer;
use Input;

class SlackController extends Controller
{


    public function slackShowMembers(Request $request) {


        if (Input::get('token')!=config('services.slack.members')) {
            return response()->json(['success'=>false, 'error'=>'Invalid token']);
        }

        if (!$community = Community::where('subdomain','=',e(Input::get('text')))->first()) {
            return response()->json(['success'=>false, 'error'=>'Invalid subdomain']);
        }

        $all_members = $community->members()->get();
        $members = $all_members->count().' members in the <https://'.$community->subdomain.''.config('app.domain').'|'.$community->name.'> hub:'."\n";

        foreach ($all_members as $member) {
            $members .= $member->getDisplayName().', ';
        }

        $message['response_type'] = 'in_channel';
        $message['text'] = $members;

        return $message;

    }

}
