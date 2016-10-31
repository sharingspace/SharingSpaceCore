<?php
/**
 * This model handles relationships related to Communities for
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
use App\ExchangeType;
use Watson\Validating\ValidatingTrait;
use App\UploadableFileTrait;
use Carbon\Carbon;
use Log;

class Community extends Model
{

    use ValidatingTrait;
    use UploadableFileTrait;

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'communities';

    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;

    protected $rules = [
      'name'            => 'required|string|min:2|max:255',
      'subdomain'       => 'required|alpha_dash|min:2|max:255|unique:communities,subdomain,NULL,deleted_at',
      'group_type'      => 'required',
    ];

    protected $dates = ['deleted_at', 'subdomain_expires_at', 'limittypes_expires_at'];

    /*
    * Set traits for uploadable image
    */

    public static $uploadableImgs = [
      'community-covers' =>
        [
          'height' => '300',
          'width' => '1300',
        ],
      'community-logos' =>
        [
          'height' => '40',
          'width' => '250',
        ],
      'community-profiles' =>
        [
          'height' => '250',
          'width' => '250',
        ],
    ];


    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name','subdomain','group_type','cover_img','profile_img','logo'];

    /**
    * Relationship to get community owner
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function owner()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
    * Relationship for entries and communities
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function entries()
    {
        return $this->belongsToMany('App\Entry', 'entries_community_join', 'community_id', 'entry_id');
    }


    /**
    * Get the members of a group.
    * Groups belong to many users by way of the communities_users table.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function members()
    {
        return $this->belongsToMany('App\User', 'communities_users', 'community_id', 'user_id')->withPivot('is_admin');
    }

   /**
    * Gets a list of join requests for the community, ignore anyone rejected or approved
    *
    * @author [D. Linnard] [<dslinnard@yahoo.com>]
    * @param $request
    * @since  [v1.0]
    * @return View
    */
    public function requests()
    {
        return $this->belongsToMany('App\User', 'community_join_requests', 'community_id', 'user_id')->whereNull('approved_by')->whereNull('rejected_by')->withPivot('message');
    }


    /**
    * Mark that a user request to a closed hub has been rejected
    *
    * @author [D. Linnard] [<dslinnard@yahoo.com>]
    * @since  [v1.0]
    * @return collection
    */
    public function rejectUser($rejected_by, $user_id, $community_id)
    {
        $user_request = \App\CommunityJoinRequest::where('user_id', '=', $user_id)->where('community_id', '=', $community_id)->first();
        $user_request->rejected_at = Carbon::now();
        $user_request->rejected_by = $rejected_by;
        $user_request->save();
    }


   /**
    * Mark that a user request to a closed hub has been accepted
    *
    * @author [D. Linnard] [<dslinnard@yahoo.com>]
    * @since  [v1.0]
    * @return collection
    */
    public function acceptUser($approved_by, $user_id, $community_id)
    {
        $user_request = \App\CommunityJoinRequest::where('user_id', '=', $user_id)->where('community_id', '=', $community_id)->first();
        $user_request->approved_at = Carbon::now();
        $user_request->approved_by = $approved_by;
        $user_request->save();
    }


   /**
    * Get the number of join requests for the community, ignore anyone rejected or approved
    *
    * @author [D. Linnard] [<dslinnard@yahoo.com>]
    * @param $request
    * @since  [v1.0]
    * @return View
    */    
    public function requestCount()
    {
        return count($this->requests()->get());
    }


    /**
    * Get the admins of a community.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function admins()
    {
        return $this->members()->where('is_admin','=',1);
    }

    /**
    * Get the cover image url based on app environment
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return string
    */
    public function getCover()
    {
        $cover_img = null;

        if ($this->cover_img!='') {
            $cover_img = config('services.cdn.default').'/uploads/community-covers/'.$this->id.'/'.$this->cover_img;
        }

        return $cover_img;
    }


    /**
    * Get the logo image url based on app environment
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return string
    */
    public function getLogo()
    {

        if ($this->logo) {
            return config('services.cdn.default').'/uploads/community-logos/'.$this->id.'/'.$this->logo;
        } else {
            return false;
        }
    }

    /**
    * Get the profile image url based on app environment
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return string
    */
    public function getProfileImg()
    {

        if ($this->profile_img!='') {
            return config('services.cdn.default').'/uploads/community-profiles/'.$this->id.'/'.$this->profile_img;
        } else {
            return false;
        }
    }

    /**
     * Get the profile image url based on app environment
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return string
     */
    public function getCommunityUrl()
    {
        return 'https://'.$this->subdomain.'.'.config('app.domain');
    }


    /**
    * Relationship for community subscription
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function subscription()
    {
        return $this->hasOne('\App\CommunitySubscription', 'id', 'community_id');
    }


    /**
    * Save the image to the DB. This method handles cover images, logos and profile images.
    *
    * @todo   Remove upload key, since it's not used here.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return boolean
    */
    public static function saveImageToDB($id, $filename, $type, $upload_key = null)
    {

        if ($community = Community::find($id)) {

            switch ($type) {
                case 'community-covers':
                    $community->cover_img = $filename;
                    break;
                case 'community-profiles':
                    $community->profile_img = $filename;
                    break;
                case 'community-logos':
                    $community->logo = $filename;
                    break;
            }

            if (!$community->save()) {
                return false;
            }
        }

        return false;
    }

    /**
    * Get the exchange types allowed in this community.
    * ExchangeType Types belong to many communities by way of the group_allowed_types table.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function exchangeTypes()
    {
        $exchanges = $this->belongsToMany('App\ExchangeType', 'community_allowed_types', 'community_id', 'type_id')->withTimestamps();

        return $exchanges;
    }


    /**
    * Query scope to only return publicly viewable communities.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeIsPublic()
    {
        return $this->where('group_type', '!=', 'S');
    }

    /**
    * Is a community open?
    *
    * @author [D.Linnard] [<dslinnard@yahoo.com>]
    * @since  [v1.0]
    * @return Boolean
    */
    public function isOpen()
    {
        return ($this->group_type == 'O');
    }

    /**
    * scopeEntriesInCommunity
    * Get all entries that are in the current community
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @param  $query
    * @param  array $categoryIdListing
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeEntriesInCommunity($query)
    {
        return $query->whereIn('category_id', $categoryIdListing);
    }
}
