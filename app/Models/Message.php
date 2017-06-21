<?php
/**
 * This model handles relationships for Messages in
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Models;

use App\collection;
use App\ExchangeTypes;
use Config;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
use Watson\Validating\ValidatingTrait;

class Message extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'messages';

    use ValidatingTrait;
    use SoftDeletes;

    /*
    * Model validation rules
    */
    protected $rules = [
      'message'        => 'required|string|min:2',
      'sent_to'        => 'required',
      'sent_by'        => 'required',
    ];


    /**
     * Messages by thread
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return \Illuminate\Support\Collection
     */
    public function conversation() {
        return $this->belongsTo('App\Models\Conversation', 'thread_id');
    }


    /**
    * Return the sender of a message
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sent_by');
    }

    /**
    * Return the recipient of a message
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function recipient()
    {
        return $this->belongsTo('App\Models\User', 'sent_to');
    }

    /**
     * Shows what community the message was sent from
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function community()
    {
        // return $this->hasManyThrough('App\Community','App\Conversation','community_id','id');
        // return $this->belongsTo('App\Community', 'conversations', 'thread_id', 'community_id');
    }


    /**
    * Marks the message as read
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return boolean
    */
    public function markMessageRead() {
        $dt = new DateTime;
        return DB::table('messages')
            ->where('id', $this->id)
            ->update(array('read_on' => $dt->format('Y-m-d H:i:s')));
    }

    /**
    * Marks the message as deleted
    *
    * @author [D.Linnard] [<dslinnard@gmail.com>]
    * @param int $userId
    * @since  [v1.0]
    * @return boolean
    */
    public function markMessageDeleted($user_id)
    {
        $message = \App\Message::find($this->id);
        if (!empty($message)) {
            //log::debug("markMessageDeleted message found ".$this->id);

            if ($user_id == $message->sent_by) {
                $deleted_by = "deleted_by_sender";
            }
            else {
                $deleted_by = "deleted_by_recipient";
            }

            return DB::table('messages')
                ->where('id', $this->id)
                ->update(array($deleted_by => $user_id));
        }
        else {
            //log::debug("markMessageDeleted message not found ".$this->id);
        }
        

        return false;
    }    

    public static function getSentToUser($user_id)
    {
        $messages = Message::join('entries', 'entry.id', '=', 'messages.entry_id')
            ->join('users', 'users.id', '=', 'messages.sent_by')
            ->where('sent_to', '=', $user_id)
            ->whereNull('users.deleted_at')
            ->orderBy('messages.sent_on', 'desc')
            ->get();

        $messages->load('sender','recipient','tile');

        return $messages;
    }


    /**
    * Checks whether user has deleted the message
    *
    * @author [D.Linnard] [<dslinnard@gmail.com>]
    * @param int $userId
    * @since  [v1.0]
    * @return boolean
    */
    public function messageDeleted($user_id)
    {
        $message = \App\Message::find($this->id);
        if (!empty($message)) {

            if (($user_id == $message->deleted_by_sender) || 
                ($user_id == $message->deleted_by_recipient)) {
                //log::debug("messageDeleted message has been deleted");
                return true;
            }
            else {
                //log::debug("messageDeleted message has not been deleted");
                return false;
            }
        }
        else {
            //log::debug("messageDeleted message could not be found ".$this->id);
        }
        
        return true;
    }    
}
