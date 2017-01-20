<?php
/**
 * This controller handles all slack webhook actions.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Community;
use Input;
use App\Entry;
use App\User;
use DB;

class SlackController extends Controller
{


    /**
    * Returns a JSON response for Slack that lists the members of a community.
    *
    * Usage:
    * /members <community-subdomain>
    *
    * Example:
    * /members nycpets
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return String JSON
    */
    public function slackShowMembers()
    {

        $message['response_type'] = 'in_channel';
        $count = 0;

        if (!$community = Community::where('subdomain', '=', e(Input::get('text')))->first()) {
            $message['text'] = 'Invalid community.';
            return response()->json($message);
        }

        if (Input::get('token')!=$community->slack_slash_members_token) {
            $message['text'] = 'That token is incorrect.';
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

    /**
    * Returns a JSON response for Slack that adds a want or a have.
    *
    * Usage:
    * /want <qty> <title> in:<community-subdomain>
    * /have <qty> <title> in:<community-subdomain>
    *
    * Examples:
    * /want a puppy crate in:nycpets
    * /have 7 puppy crates in:nycpets
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return String JSON
    */
    public function slackAddEntry($postType = 'want')
    {
        $text_pre = explode(' in:', Input::get('text'));
        // eg. 'text_pre' => ('1 junk', 'testgroup')
        $text = explode(' ', $text_pre[0]);
        // eg. 'text' => ('1', 'junk'), 
        $community_slug = trim($text_pre[1]);
        // eg. 'community_slug' => 'testgroup',

        if ($community_slug) {
            if (!$community = Community::where('subdomain', '=', e($community_slug))->first()) {
                $message['text'] = 'The '.e($community_slug).' community is invalid.';
                return response()->json($message);
            }
        }
        else {
            $message['text'] = 'No community given.';
            return response()->json($message);
        }


        $entry = new Entry;

        if (!is_numeric($text[0])) {
            $entry->qty = 1;
        } else {
            $entry->qty = $text[0];
        }

        if (array_key_exists('0', $text_pre)) {
            $entry->title = $text_pre[0];
        } else {
            $entry->title = $text[0];
        }

        if ($postType=='want') {
            $entry->post_type = 'want';
            $use_token = $community->slack_slash_want_token;
        } else {
            $entry->post_type = 'have';
            $use_token = $community->slack_slash_have_token;
        }

        $message['response_type'] = 'in_channel';

        if (Input::get('token')!=$use_token) {
            $message['text'] = 'That token is incorrect.';
            return response()->json($message);
        }



        // TODO: This is messy and should be refactored
        $slack_users = DB::table('communities_users')
        ->select('*')
        ->where('slack_name', '=', e(Input::get('user_name')))
        ->where('community_id', '=', $community->id)
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
            $message['text'] = 'A new '.strtoupper($entry->post_type).' entry for   <https://'.$community->subdomain.'.'.config('app.domain').'/entry/'.$entry->id.'|'.$entry->title.'> was added to '.$community_slug.'!';
        } else {
            $message['text'] = 'Error ';
        }


        return response()->json($message);

    }
}
