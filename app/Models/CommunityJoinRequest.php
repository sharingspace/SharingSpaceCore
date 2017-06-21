<?php
/**
 * This model handles relationships for user request to join a closed hub for
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Models;

use App\collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CommunityJoinRequest extends Model
{
  /**
  * The database table used by the model.
  *
  * @var string
  */
    protected $table = 'community_join_requests';

    /**
    * Returns user associated with a request
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function user()
    {   
        // a request belongs to a user
        return $this->belongsTo('App\Models\User');
    }

    public function community()
    {   
        // a request belongs to a user
        return $this->belongsTo('App\Models\Community');
    }

 

}
