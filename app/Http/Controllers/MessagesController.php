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
use App\Message;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $messages = Auth::user()->messagesTo();
        return view('messages.view')->with('messages', $messages);
    }

}
