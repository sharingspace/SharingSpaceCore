<?php
/**
 * This controller handles all actions related to Entries for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Theme;
use Validator;
use Input;
use Redirect;
use Helper;
use Log;
use Gate;
use App\Message;
use App\Conversation;
use App\Entry;
use App\User;
use Config;

class MessagesController extends Controller
{

    /**
     * Returns a view that displays a list of messages
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @internal param $Request
     * @return View
     *
     */
    public function getIndex(Request $request)
    {
        $messages = Auth::user()->messagesTo()
            ->with('conversation.entry','sender','conversation','conversation.community')
            ->groupBy('thread_id')
            ->orderBy('created_at', 'DESC')->get();

        return view('account/inbox')->with('messages', $messages);
    }

     /**
     * Returns a view that displays a specific message thread
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @internal param $Request
     * @param int $conversationId
     * @return View
     */
    public function getMessageThread(Request $request, $conversationId)
    {
        //log::debug("getMessageThread: threadId = ".$conversationId);
        if ($conversation = Conversation::with(['entry','sender', 'messages' => function ($query) {
            $query->where('messages.deleted_by_recipient', '<>', Auth::user()->id)
            ->where('messages.deleted_by_sender', '<>', Auth::user()->id)
            ->orderBy('messages.created_at', 'desc');
        }])->find($conversationId))
    
        {
            if ($request->user()->cannot('view-conversation', $conversation)) {
                return redirect()->route('browse')->with('error', trans('general.messages.messages.unauthorized'));
            }

            foreach ($conversation->messages as $message) {
               $message->markMessageRead();
            }
            return view('account/messages')->with('conversation', $conversation);
        }

        return redirect()->to('browse')->with('error', trans('general.messages.messages.not_found'));
    }

    /**
    * Handles AJAX request to delete a message.
    *
    * @todo Work how to delete a message on one or both sides of the convesation
    * @author [D. Linnard] [<sdslinnard@gmail.com>]
    * @since  [v1.0]
    * @internal param $Request
    * @param int $messageId
    * @return json repsonse, true or false
    */    
    public function postDeleteMessage(Request $request, $messageId)
    {
        //log::debug("postDeleteMessage: entered");
        if ($message = \App\Message::find($messageId)) {

            if ($message->markMessageDeleted(Auth::user()->id)) {
                return response()->json(['success'=>true, 'messageId'=>$messageId]);
            }
        }

        return response()->json(['success'=>false]);
    }


    /**
    * Handles AJAX request to create a new message.
    *
    * The $userId is always required, because we do not store the recipients' ID in the conversation
    * (thread) record. The $entryId is optional, so that people can send messages from a user's profile.
    *
    * @todo Fix the jankiness with thread_id
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @internal param $Request
    * @param int $userId
    * @param int $entryId
    * @return View
    */
    public function postCreate(Request $request, $userId, $entryId = null)
    {
        $data = array();
        $conversation = null;

        $recipient = User::find($userId);
        if ($entryId) {
            $entry = Entry::find($entryId);
            if (!empty($entry)) {
                $data['entry_name'] = $entry->title;
                $data['entry_id'] = $entry->id;
                $data['post_type'] = $entry->post_type;
            }
        }

        $exchanges = array();
        if (Input::has('exchange_types')) {
            $exchanges_types = Input::get('exchange_types');
            foreach ($exchanges_types as $et) {
                $exchanges[] = $et;
            }

            $data['exchanges']  =implode(", ", $exchanges);
        }

        if (Input::has('thread_id')) {
            //log::debug("postCreate: thread_id = ".Input::get('thread_id'));
            $conversation = Conversation::find(e(Input::get('thread_id')));
        }
        else {
            // Find the thread ID by the subject, entry_id, started_by and community_id.
            // If there is no matching thread, create one.
            $conversation = Conversation::firstOrCreate([
                'subject' => e(Input::get('subject')),
                'entry_id' => $entryId,
                'started_by' => Auth::user()->id,
                'community_id' => $request->whitelabel_group->id,
            ]);
        }

        if (!empty($conversation)) {
            $data['thread_subject'] = e(Input::get('thread_subject'));
            $data['thread_id'] = $conversation->id;
        }

        $offer = new Message;
        $offer->message = e(Input::get('message'));
        $offer->sent_by = Auth::user()->id;
        $offer->sent_to = $userId;

        // Associate the conversation with the new message (via thread_id) in the messages table
        $conversation = $offer->conversation()->associate($conversation);

        $data['email'] = $send_to_email = $recipient->email;
        $data['name'] = $send_to_name =  $recipient->getDisplayName();
        $data['offer'] = $offer->message;
        $data['community'] = ucfirst($request->whitelabel_group->name);
        $data['community_url'] = 'https://'.$request->whitelabel_group->subdomain.'.'.Config::get('app.domain');

        if (!empty($request->whitelabel_group->logo)) { //.
            // just for testing locally 
            //$img = 'https://anyshare.coop/assets/img/hp/anyshare-logo-beta.png';
            $img = public_path()."/assets/uploads/community-logos/".$request->whitelabel_group->id."/".$request->whitelabel_group->logo;

            $data['logo'] = '<img src="'.$img.'" height="41" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">';
        }
        
        if ($offer->save()) {
            \Mail::send('emails.email-msg', $data, function ($m) use ($recipient, $request) {
                $m->to($recipient->email, $recipient->getDisplayName())->subject('New message from '.e($request->whitelabel_group->name));
            });
            return response()->json(['success'=>true, 'message'=>trans('general.messages.sent')]);
        }
        else {
            return response()->json(['success'=>false, 'error'=>$offer->getErrors()]);
        }
    }
}
