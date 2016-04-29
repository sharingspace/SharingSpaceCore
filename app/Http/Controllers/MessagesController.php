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
use App\Entry;

class MessagesController extends Controller
{

    /**
    * Returns a view that displays a list of messages
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return View
    */
    public function getIndex(Request $request)
    {
        $messages = Auth::user()->messagesTo()->with('entry','sender')->get();
        return view('account/inbox')->with('messages', $messages);
    }




    public function postCreate(Request $request, $entryId = null) {


        //return response()->json(['success'=>true, 'message'=>'poopyface']);
        $message = new Message;
        if ($entryId) {
            $entry = Entry::find($entryId)->first();
        }

        $message->message = e(Input::get('message'));
        $message->sent_by = Auth::user()->id;
        $message->sent_to = $entry->created_by;
        if ($entry) {
            $message->entry_id = $entry->id;
        }


        if ($message->save()) {
            return response()->json(['success'=>true, 'message'=>trans('general.messages.sent')]);
        } else {
            return response()->json(['success'=>false, 'error'=>$message->getErrors()]);
        }
    }


}
