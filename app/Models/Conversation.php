<?php
/**
 * This model handles relationships for Message Conversations in
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
use App\UploadableFileTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    protected $table = 'conversations';

    use ValidatingTrait;
    use UploadableFileTrait;
    use SoftDeletes;

    /*
    * Model validation rules
    */
    protected $rules = [
        'subject'        => 'required|string|min:2',
        'started_by'        => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'started_by',  'community_id', 'entry_id'];

    /**
     * Messages by thread
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return \Illuminate\Support\Collection
     */
    public function messages()
    {
        return $this->hasMany('App\Message', 'thread_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'started_by');
    }

    public function entry()
    {
        return $this->belongsTo('App\Entry', 'entry_id');
    }


    public function findSendToId(User $sender)
    {
        foreach ($this->messages as $message) {
           if ($message->sent_to != $sender->id) {
               return $message->sent_to;
           } else {
               return $message->sent_by;
           }
        }
    }

    public function checkUserInConvo(User $user)
    {
        foreach ($this->messages as $message) {
            if (($message->sent_to ==  $user->id) || ($message->sent_by == $user->id)) {
                return true;
            }
        }
        return false;
    }


}
