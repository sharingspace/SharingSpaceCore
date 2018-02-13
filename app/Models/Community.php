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

namespace App\Models;

use App\Collection;
use App\Illuminate;
use App\View;
use Illuminate\Database\Eloquent\Model;
use Config;
use App\Models\User;
use App\Models\ExchangeType;
use Watson\Validating\ValidatingTrait;
use App\UploadableFileTrait;
use Carbon\Carbon;
use DB;
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
        'name'       => 'required|string|min:2|max:255',
        'subdomain'  => 'required|alpha_dash|min:2|max:255|unique:communities,subdomain,NULL,deleted_at',
        'group_type' => 'required',
    ];

    protected $dates = ['deleted_at', 'subdomain_expires_at', 'limittypes_expires_at'];

    /*
    * Set traits for uploadable image
    */

    public static $uploadableImgs = [
        'community-covers'   =>
            [
                'height' => '300',
                'width'  => '1300',
            ],
        'community-logos'    =>
            [
                'height' => '40',
                'width'  => '250',
            ],
        'community-profiles' =>
            [
                'height' => '250',
                'width'  => '250',
            ],
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'subdomain', 'group_type', 'cover_img', 'profile_img', 'logo', 'wrld3d', 'lat', 'lng'];

    /**
     * @var array
     */
    protected $casts = [
        'wrld3d' => 'collection',
    ];

    /**
     * Relationship to get community owner
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

   /**
     * Get a list of all communities.
     *
     * @author [D.Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return collection
     */
    public static function communities()
    {
        return self::all();
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
        return $this->belongsToMany('App\Models\Entry', 'entries_community_join', 'community_id', 'entry_id');
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
        return $this->belongsToMany('App\Models\User', 'communities_users', 'community_id', 'user_id')->withPivot('is_admin', 'custom_label');
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
        return $this->belongsToMany('App\Models\User', 'community_join_requests', 'community_id', 'user_id')->whereNull('approved_by')->whereNull('rejected_by')->withPivot('message');
    }

    /**
     * @return mixed
     */
    public function getLatitudeAttribute()
    {
        return $this->lat;
    }

    /**
     * Set the lat attribute when code tries to change latitude attribute.
     *
     * @param $value
     */
    public function setLatitudeAttribute($value)
    {
        $this->attributes['lat'] = $value;
    }

    /**
     * @return mixed
     */
    public function getLongitudeAttribute()
    {
        return $this->lng;
    }

    /**
     * Set the lng attribute when code tries to update longitude attribute.
     *
     * @param $value
     */
    public function setLongitudeAttribute($value)
    {
        $this->attributes['lng'] = $value;
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
        $user_request = \App\Models\CommunityJoinRequest::where('user_id', '=', $user_id)->where('community_id', '=', $community_id)->first();
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
        $user_request = \App\Models\CommunityJoinRequest::where('user_id', '=', $user_id)->where('community_id', '=', $community_id)->first();
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
        return $this->members()->where('is_admin', '=', 1);
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

        if ($this->cover_img != '') {
            $cover_img = config('services.cdn.default') . '/uploads/community-covers/' . $this->id . '/' . $this->cover_img;
        }

        return $cover_img;
    }

    /**
     * Deletes cover image.
     *
     * @author [D. Linnard] [<david@linnard.com>]
     * @since  [v1.0]
     * @return no return
     */
    public function deleteCover()
    {
        //log::debug("deleteCover: ".$this->cover_img);
        $file = public_path() . '/assets/uploads/community-covers/' . $this->id . '/' . $this->cover_img;
        unlink($file);
        $this->cover_img = null;
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
            return config('services.cdn.default') . '/uploads/community-logos/' . $this->id . '/' . $this->logo;
        }
        else {
            return false;
        }
    }

    /**
     * Deletes logo image.
     *
     * @author [D. Linnard] [<david@linnard.com>]
     * @since  [v1.0]
     * @return no return
     */
    public function deleteLogo()
    {
        $file = public_path() . '/assets/uploads/community-logos/' . $this->id . '/' . $this->logo;
        unlink($file);
        $this->logo = null;
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

        if ($this->profile_img != '') {
            return config('services.cdn.default') . '/uploads/community-profiles/' . $this->id . '/' . $this->profile_img;
        }
        else {
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
        return 'https://' . $this->subdomain . '.' . config('app.domain');
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
        return $this->hasOne('\App\Models\CommunitySubscription', 'id', 'community_id');
    }


    /**
     * Save the image to the DB. This method handles cover images, logos and profile images.
     *
     * @todo   Remove upload key, since it's not used here.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return boolean
     */
    public static function saveImageToDB($community_id, $filename, $type, $user_id = null, $upload_key = null)
    {
        //log::debug("Community::saveImageToDB " . $community_id . ", " . $filename . ", " . $type);

        if ($community = Community::find($community_id)) {

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
                log::error("saveImageToDB: failed");

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
        $exchanges = $this->belongsToMany('App\Models\ExchangeType', 'community_allowed_types', 'community_id', 'type_id')->withTimestamps();

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
     * Query scope to only return publicly viewable communities.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function viewNavItems()
    {
        return ((\Auth::check() && \Auth::user()->canSeeCommunity($this)) || $this->group_type != 'S');
    }

    /**
     * Can view members page
     *
     * @author [D.Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return Boolean
     */
    public function viewMembers()
    {
        return ((\Auth::check() && \Auth::user()->isMemberOfCommunity($this)) || ($this->group_type != 'S'));
    }

    /**
     * Can view browse page
     *
     * @author [D.Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return Boolean
     */
    public function viewBrowse()
    {
        return ((\Auth::check() && \Auth::user()->isMemberOfCommunity($this)) || ($this->group_type != 'S'));
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
     * Is a community closed?
     *
     * @author [D.Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return Boolean
     */
    public function isClosed()
    {
        return ($this->group_type == 'C');
    }

    /**
     * Is a community secret?
     *
     * @author [D.Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return Boolean
     */
    public function isSecret()
    {
        return ($this->group_type == 'S');
    }


    /**
     * Get entry layout mode, grid or list
     *
     * @author [D.Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return "G" or "L"
     */
    public function getLayout()
    {
        return $this->entry_layout;
    }

    /**
     * scopeEntriesInCommunity
     * Get all entries that are in the current community
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @param        $query
     * @param  array $categoryIdListing
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeEntriesInCommunity($query)
    {
        return $query->whereIn('category_id', $categoryIdListing);
    }

    public function getRequestCount($user_id)
    {
        // find out whther they have already asked to join this share
        return $request_count = DB::table('community_join_requests')
            ->where('user_id', '=', $user_id)
            ->where('community_id', '=', $this->id)
            ->whereNull('approved_by')
            ->count();
    }

    /**
     * Return whether the community has geolocation set up.
     *
     * @return bool
     */
    public function hasGeolocation(): bool
    {
        return $this->latitude && $this->longitude;
    }

    /**
     * Determine whether the community has an Wrld 3D POI Set.
     *
     * @return bool
     */
    public function hasWrld3dPoiset(): bool
    {
        return $this->wrld3d && $this->wrld3d->get('poiset');
    }
}
