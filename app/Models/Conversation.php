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
use Conversation;

class Conversation extends Model
{
    protected $table = 'messages';

    use ValidatingTrait;
    use UploadableFileTrait;
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
    public function messages() {
        return $this->hasMany('App\Message', 'thread_id');
    }

}
