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
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;
use App\ExchangeTypes;
use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Conversation;
use DateTime;
use DB;

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
        return $this->belongsTo('App\Conversation', 'thread_id');
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
        return $this->belongsTo('App\User', 'sent_by');
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
        return $this->belongsTo('App\User', 'sent_to');
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


}
