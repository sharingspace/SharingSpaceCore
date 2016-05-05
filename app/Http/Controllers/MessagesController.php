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
use Illuminate\Routing\Controller;
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
        $messages = Auth::user()->messagesTo()->with('entry','sender','conversation')->groupBy('thread_id')->get();
        return view('account/inbox')->with('messages', $messages);
    }

     /**
     * Returns a view that displays a specific message
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @internal param $Request
     * @param int $conversationId
     * @return View
     */
    public function getMessage(Request $request, $conversationId)
    {
        $conversation = Conversation::with('entry','sender','messages')->find($conversationId);
        return view('account/message')->with('conversation', $conversation);
    }




     /**
     * Handles AJAX request to create a new message.
     *
     * The $userId is always required, because we do not store the recipients' ID in the conversation
     * (thread) record. The $entryId is optional, so that people can send messages from a user's profile.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @internal param $Request
     * @param int $userId
     * @param int $entryId
     * @return View
     */
    public function postCreate(Request $request, $userId, $entryId = null) {

        $recipient = User::find($userId);

        if ($entryId) {
            $entry = Entry::find($entryId);
            $data['entry_name'] = $entry->name;
            $data['entry_id'] = $entry->id;
            $data['post_type'] = $entry->post_type;
        }

        // Find the thread ID by the subject, entry_id, started_by and community_id.
        // If there is no matching thread, create one.
        $conversation = Conversation::firstOrCreate([
            'subject' => e(Input::get('subject')),
            'entry_id' => $entryId,
            'started_by' => Auth::user()->id,
            'community_id' => $request->whitelabel_group->id,
        ]);
        
        $offer = new Message;
        $offer->message = e(Input::get('message'));
        $offer->sent_by = Auth::user()->id;
        $offer->sent_to = $userId;

        // Associate the conversation with the new message (via thread_id) in the messages table
        $conversation = $offer->conversation()->associate($conversation);

        $data['email'] = $send_to_email = $recipient->email;
        $data['name'] = $send_to_name =  $recipient->getDisplayName();
        $data['thread_id'] = $conversation->id;
        $data['subject'] = $conversation->subject;
        $data['offer'] = $offer->message;

        $data['community'] = $request->whitelabel_group->name;
        $data['community_url'] = 'https://'.$request->whitelabel_group->subdomain.'.'.Config::get('app.domain');


        if ($offer->save()) {

            \Mail::send('emails.email-msg', $data, function ($m) use ($recipient, $request) {
                $m->to($recipient->email, $recipient->getDisplayName())->subject('New message from '.e($request->whitelabel_group->name));
            });
            return response()->json(['success'=>true, 'message'=>trans('general.messages.sent')]);
        } else {
            return response()->json(['success'=>false, 'error'=>$offer->getErrors()]);
        }
    }




    public function postCreateDirect(Request $request, $userId = null) {

        $message = new Message;

        if ($entryId) {
            $entry = Entry::find($entryId)->first();
        }

        if ($userId) {
            $user = User::find($userId)->first();
        }

        $message->message = e(Input::get('message'));
        $message->sent_by = Auth::user()->id;

        if ($entry) {
            $message->sent_to = $entry->created_by;
            $message->entry_id = $entry->id;
        } else {
            $message->sent_to = $user->id;
        }


        if ($message->save()) {
            Mail::send(array('emails.new-msg'), $data, function($message) use ($sendto_email, $sendto_fullname, $msg_subject)
            {
                $message->to($sendto_email, $sendto_fullname)->subject($msg_subject);
            });

            return response()->json(['success'=>true, 'message'=>trans('general.messages.sent')]);
        } else {
            return response()->json(['success'=>false, 'error'=>$message->getErrors()]);
        }
    }


}
