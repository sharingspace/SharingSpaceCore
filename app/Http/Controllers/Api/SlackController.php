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

        $message['response_type'] = 'in_channel';
        $count = 0;

        if (Input::get('token')!=config('services.slack.members')) {
            $message['text'] = 'That token is incorrect.';
        }

        if (!$community = Community::where('subdomain','=',e(Input::get('text')))->first()) {
            $message['text'] = 'Invalid community.';
        }

        $all_members = $community->members()->get();
        $members = $all_members->count().' members in the <https://'.$community->subdomain.'.'.config('app.domain').'|'.$community->name.'> hub:'."\n";

        foreach ($all_members as $member) {

            $members .= $member->getDisplayName();
            if (count($all_members) > $count) {
                $members .= ', ';
            }
            $count++;
        }


        $message['text'] = $members;

        return response()->json($message);

    }

}
