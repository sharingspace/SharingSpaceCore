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
        $messages = Auth::user()->messagesTo()
            ->with('conversation.entry','sender','conversation','conversation.community')
            ->groupBy('thread_id')
            ->orderBy('created_at', 'DESC')->get();
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

        if ($conversation = Conversation::with('entry','sender','messages')->find($conversationId)) 
        {

            if ($request->user()->cannot('view-conversation', $conversation)) {
                return redirect()->route('browse')->with('error', trans('general.messages.messages.unauthorized'));
            }

            foreach ($conversation->messages as $message) {
                $message->markMessageRead();
            }
            return view('account/message')->with('conversation', $conversation);
            
        }

        return redirect()->to('browse')->with('error', trans('general.messages.messages.not_found'));

        
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
    public function postCreate(Request $request, $userId, $entryId = null) {

        $recipient = User::find($userId);

        if ($entryId) {
            $entry = Entry::find($entryId);
            $data['entry_name'] = $entry->name;
            $data['entry_id'] = $entry->id;
            $data['post_type'] = $entry->post_type;
        }

        if (Input::has('thread_id')) {
            $conversation = Conversation::find(e(Input::get('thread_id')));
        } else {
            // Find the thread ID by the subject, entry_id, started_by and community_id.
            // If there is no matching thread, create one.
            $conversation = Conversation::firstOrCreate([
                'subject' => e(Input::get('subject')),
                'entry_id' => $entryId,
                'started_by' => Auth::user()->id,
                'community_id' => $request->whitelabel_group->id,
            ]);
        }

        
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
    

}
