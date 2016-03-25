<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\Community;
use App\Http\Transformers\CommunityTransformer;
use App\Http\Transformers\MemberlistTransformer;
use Input;
use App\Entry;
use App\User;
use DB;

class SlackController extends Controller
{


    public function slackShowMembers(Request $request) {

        $message['response_type'] = 'in_channel';
        $count = 0;

        if (Input::get('token')!=config('services.slack.members')) {
            $message['text'] = 'That token is incorrect.';
            return response()->json($message);
        }

        if (!$community = Community::where('subdomain','=',e(Input::get('text')))->first()) {
            $message['text'] = 'Invalid community.';
            return response()->json($message);
        }

        $all_members = $community->members()->get();
        $members = $all_members->count().' members in the <https://'.$community->subdomain.'.'.config('app.domain').'|'.$community->name.'> hub:'."\n";

        foreach ($all_members as $member) {
            $count++;
            $members .= '<https://'.$community->subdomain.'.'.config('app.domain').'/users/'.$member->id.'|'.$member->getDisplayName().'>';
            if (count($all_members) > $count) {
                $members .= ', ';
            }

        }

        $message['text'] = $members;

        return response()->json($message);

    }

    public function slackAddWantEntry(Request $request) {

        $text_pre = explode(' in:',Input::get('text'));
        $text = explode(' ',$text_pre[0]);
        $community_slug = trim($text_pre[1]);


        $entry = new Entry;

        if (!is_numeric($text[0])) {
            $entry->qty = 1;
        } else {
            $entry->qty = $text[0];
        }

        if (array_key_exists('0',$text_pre)) {
            $entry->title = $text_pre[0];
        } else {
            $entry->title = $text[0];
        }

        $entry->post_type = 'want';


        //$message['response_type'] = 'ephemeral';
        $message['response_type'] = 'in_channel';

        if (Input::get('token')!=config('services.slack.need')) {
            $message['text'] = 'That token is incorrect.';
            return response()->json($message);
        }

        if ($community_slug) {
            if (!$community = Community::where('subdomain','=',e($community_slug))->first()) {
                $message['text'] = 'The '.e($text[2]).' community is invalid.';
                return response()->json($message);
            }
        } else {
            $message['text'] = 'No community given.';
            return response()->json($message);
        }

        // TODO: This is messy and should be refactored
        $slack_users = DB::table('communities_users')
        ->select('*')
        ->where('slack_name','=',e(Input::get('user_name')))
        ->where('community_id','=',$community->id)
        ->first();

        if (!$slack_users) {
            $message['text'] = 'No matching user for this community.';
            return response()->json($message);
        }

        if (!$user = User::find($slack_users->user_id)) {
            $message['text'] = 'No matching user for this community.';
            return response()->json($message);
        } else {
            $entry->created_by = $user->id;
        }

        if ($community->entries()->save($entry)) {
            $entry->exchangeTypes()->sync(\App\ExchangeType::all());
            //$community->exchangeTypes()->saveMany(\App\ExchangeType::all());
            $message['text'] = $entry->title.' added to '.$community_slug.'!';
        } else {
            $message['text'] = 'Error ';
        }





        return response()->json($message);

    }

}
