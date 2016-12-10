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
use Mail;

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
     * Returns a view that displays a single messages
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @internal param $Request
     * @return View
     *
     */
    public function getMessage(Request $request, $messageId)
    {
        $user = Auth::user();
        if ($user) {
            //log::debug("getMessage: found message ".$messageId); 

            if ($message = \App\Message::find($messageId)) {
                if (($message->sent_by == $user->id) || ($message->sent_to == $user->id)) {
                    //log::debug("getMessage: message belongs to us ".$messageId.$message->id);

                    if (!$message->messageDeleted($user->id)) {
                        $conversation = \App\Conversation::find($message->thread_id);

                        if ($conversation) {
                            //log::debug("getMessage: found conversation ".$conversation->subject);
                            return view('account/message')->with('message', $message)->with('conversation_subject', $conversation->subject);
                        }
                    }
                }
                else {
                    //log::debug("getMessage: message does not belong to user ".$messageId."  ".$user->id);
                }
            }
        }
        //log::debug("getMessage: did not find message ".$messageId);

        return view('account/message')->with('error', "No message found");
    }


     /**
     * Returns a view that displays a specific message thread
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @internal param $Request
     * @param int $conversationId
     * @return View
     * if ($conversation = Conversation::with(['entry','sender', 'messages' => function ($query) {
            $query->where('messages.deleted_by_recipient', '<>', Auth::user()->id)
            ->where('messages.deleted_by_sender', '<>', Auth::user()->id)
            ->orderBy('messages.created_at', 'desc');
        }])->find($conversationId))
     */
    public function getMessageThread(Request $request, $conversationId)
    {
        //log::debug("getMessageThread: threadId = ".$conversationId);
        if ($conversation = Conversation::with(['entry','sender', 'messages' => function ($query) {
            $query->where('messages.deleted_by_recipient', '<>', Auth::user()->id)
            ->where('messages.deleted_by_sender', '<>', Auth::user()->id);
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
        if ($message = \App\Message::find($messageId)) {
            if ($message->markMessageDeleted(Auth::user()->id)) {
                return response()->json(['success'=>true, 'message'=>"Message deleted", 'message_id' => $messageId]);
            }
        }

        return response()->json(['success'=>false, 'message'=>"Sorry message not found", 'message_id' => $messageId]);
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
        if ($recipient = User::find($userId)) {
            if ($entryId) {
                if ($entry = Entry::find($entryId)) {
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
            else {
                log::debug("postCreate: conversation empty");
            }

            $offer = new Message;
            if (!empty($offer)) {
                $offer->message = e(Input::get('message'));
                $offer->sent_by = Auth::user()->id;
                $offer->sent_to = $userId;

                // Associate the conversation with the new message (via thread_id) in the messages table
                $conversation = $offer->conversation()->associate($conversation);

                $data['email'] = $send_to_email = $recipient->email;
                $data['name'] = $recipient->getDisplayName();
                $data['offer'] = $offer->message;
                $data['community_name'] = $request->whitelabel_group->name;
                $data['community_url'] = 'https://'.$request->whitelabel_group->subdomain.'.'.config('app.domain');
                $data['sent_by_name'] = Auth::user()->getDisplayName();

                if (!empty($request->whitelabel_group->logo)) {
                    if( config('app.debug')) {
                        // this is for testing only
                        $data['logo'] = 'https://anyshare.coop/assets/img/hp/anyshare-logo-web-retina.png';
                    }
                    else {
                        $data['logo'] = public_path()."/assets/uploads/community-logos/".$request->whitelabel_group->id."/".$request->whitelabel_group->logo;
                    }
                }

                if ($offer->save()) {
                    Mail::send('emails.email-msg', $data, function ($m) use ($recipient, $request) {
                        $m->to($recipient->email, $recipient->getDisplayName())->subject('New message from '.e($request->whitelabel_group->name));
                    });

                    $messageData = ['messageId' => $offer->id,
                                'displayName' => $data['name'],
                               'avatar' => Auth::user()->gravatar_img(),
                                'senderId' => $offer->sent_by,
                                'createdAt' => date('M j, Y g:ia'),
                                'message' => $offer->message,
                                'shareName' => $request->whitelabel_group->name];

                    return response()->json(['success'=>true, 'messageData' => $messageData, 'message'=>trans('general.messages.sent')]);
                }
                else {
                    return response()->json(['success'=>false, 'message'=> trans('general.messages.sent_error')]);
                }
            }
            else {
                log::debug("postCreate: message empty");
            }
        }
        else {
            // could not find recipient
            log::debug("postCreate: could not find recipient");
        }
    }               
}
