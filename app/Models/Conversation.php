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
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\Models\User;
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
        return $this->hasMany('App\Models\Message', 'thread_id');
    }

    /**
     * Community the conversation was started in
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return \Illuminate\Support\Collection
     */
    public function community()
    {
        return $this->belongsTo('App\Models\Community', 'community_id');
    }

    /**
     * The User the conversation was started by
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return \Illuminate\Support\Collection
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'started_by');
    }

    /**
     * Entry the conversation was started about (if applicable)
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return \Illuminate\Support\Collection
     */
    public function entry()
    {
        return $this->belongsTo('App\Models\Entry', 'entry_id');
    }


    /**
     * Get the id of the person we should be replying to.
     *
     * This is a little janky because the the conversation doesn't store
     * a value for who the conversation was originally to.
     *
     * This is because we may want to open this up to group messaging down the line
     * and we don't want/need to limit that. A conversation will always
     * only be started by one person, but could be to several.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return \Illuminate\Support\Collection
     */
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

    /**
     * Make sure this user is allowed to see this conversation.
     *
     * This is used by the AuthServiceProvider for gating.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return \Illuminate\Support\Collection
     */
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
