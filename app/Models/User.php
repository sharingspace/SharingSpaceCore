<?php
/**
 * This model handles relationships and model methods for Users.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\CommunitySubscription;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cartalyst\Stripe\Billing\Laravel\Billable;
use Cartalyst\Stripe\Billing\Laravel\BillableContract;
use Watson\Validating\ValidatingTrait;
use App\UploadableFileTrait;
use App\Social;
use App\Message;
use App\Conversation;
use DB;
use Illuminate\Notifications\Notifiable;
use Log;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, BillableContract, SluggableInterface
{
    use Authenticatable, CanResetPassword, Billable, Authorizable;
    use SluggableTrait;
    use ValidatingTrait;
    use UploadableFileTrait;
    use Notifiable;

    /*
    * Set traits for uploadable image
    */

    public static $uploadableImgs = [
      'users' =>
        [
          'height' => '250',
          'width' => '250'
        ]
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $injectUniqueIdentifier = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email','password','stripe_id','display_name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * Model validation rules
     *
     * @var array
     */
    protected $rules = [
        'display_name'     => 'required|string|min:2|max:255',
        'email' => 'required|email|max:255|unique:users',
        'website'           => 'url',
        'fb_url'           => 'url',
        'twitter'      => 'url',
        'google'        => 'url',
        'pinterest'    => 'url',
        'youtube'      => 'url',
    ];

    protected $sluggable = [
        'build_from' => 'first_name',
        'save_to'    => 'slug',
    ];


    /**
    * Return a user's subscriptions.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function subscriptions()
    {
        return $this->hasMany('App\CommunitySubscription', 'billable_id');
    }


    /**
    * Return a user's social accounts.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function social()
    {
        return $this->hasMany('App\Social', 'user_id');
    }


    /**
    * Returns whether a user is a superadmin.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return boolean
    */
    public function isSuperAdmin()
    {
        if ($this->superadmin=='1') {
            return true;
        } else {
            return false;
        }
    }


    /**
    * Returns whether or not the user is an admin of a community
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param object $community
    * @since  [v1.0]
    * @return boolean
    */
    public function isAdminOfCommunity($community)
    {
        return $this->communities()
            ->where('community_id', '=', $community->id)
            ->where('is_admin', '=', '1')
            ->count() > 0;
    }


    /**
    * Returns whether or not the user can administer a community.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param object $community
    * @since  [v1.0]
    * @return boolean
    */
    public function canAdmin($community)
    {
        if (($this->isAdminOfCommunity($community)) ||  ($this->superadmin=='1')) {
            return true;
        } else {
            return false;
        }
    }


    /**
    * Return whether or not the user can view the community.
    * This is quite simply whether the user can see anything
    * of the community, home page etc. and not whether the user
    * can interact with the site.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param object $community
    * @since  [v1.0]
    * @return boolean
    */
    public function canSeeCommunity($community)
    {
        LOG::debug("canSeeCommunity: entered user id = ". $this->id.",  user name = ".$this->display_name. ", community id = ".$community->id.",  community name = ".$community->name);

        if ($this->isMemberOfCommunity($community) || $this->isSuperAdmin() || $community->group_type != 'S') { 
            LOG::debug("canSeeCommunity: user can see share, because they are either a member, they are super admin, or it is not secret");
            return true;
        }
        else {
            LOG::debug("canSeeCommunity: user cannot see share, that is it is secret and you are not a member");
            return false;
        }
    }


    /**
    * Return the URL of the user's avatar (or gravatar)
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param object $community
    * @since  [v1.0]
    * @return string
    */
    public function gravatar_img($size = null)
    {
        if (!empty($this->avatar_img)) {
            //LOG::debug("Using ".config('services.cdn.default')."/uploads/users/".$this->id."/".$this->avatar_img);
            return config('services.cdn.default')."/uploads/users/".$this->id."/".$this->avatar_img;
        } 
        else if (!empty($this->gravatar)) {
            // this can one day be removed or used to store the gravatar email hash
            //LOG::debug("Using ".config('services.cdn.default')."/uploads/users/".$this->id."/".$this->gravatar);
            return config('services.cdn.default')."/uploads/users/".$this->id."/".$this->gravatar;
        }
        else {
            return "https://gravatar.com/avatar/".md5(strtolower(trim($this->email)))."?d=mm&s=200";
        }
     }


    /**
    * Stores the social accounts associated with a user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param object $socialUser
    * @param string $provider
    * @since  [v1.0]
    * @return mixed
    */
    public static function saveSocialAccount($socialUser, $provider)
    {
        // Check to see if a user exists in the users table first
        $user =  User::where('email', '=', $socialUser->getEmail())->first();

         // There is NOT a matching email address in the user table
        if (!$user) {
            $user = new User;
            $user->email = $socialUser->getEmail();
            $user->first_name = $socialUser->getName();
            $user->display_name = $socialUser->getName();
            if (!$user->save()) {
                return false;
            }
        }

        $social = $user->social()->firstOrNew(
            ['user_id' => $user->id,
            'service'=>$provider,
            'uid' => $socialUser->getId()
            ]
        );

          $social->access_token = $socialUser->token;
          $social->save();

        return $user;
    }


    /**
    * Checks to see if a user's social info has already been saved
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param object $community
    * @since  [v1.0]
    * @return User
    */
    public static function checkForSocialLoginDBRecord($user, $provider)
    {
        return DB::table('social')
         ->where('access_token', '=', $user->token)
         ->where('service', '=', $provider)
         ->get();
    }


    /**
    * Registers a new user
    *
    * @todo More documentation on how this works.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param array $data
    * @since  [v1.0]
    * @return User
    */
    public static function register($data = [])
    {
        return static::create($data);
    }


    /**
    * Returns communities by user
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function communities()
    {
        return $this->belongsToMany('\App\Community', 'communities_users', 'user_id', 'community_id')->withPivot('custom_label');
    }

 
    /**
    * Returns entries by user
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function entries()
    {
		return $this->hasMany('\App\Entry','created_by');
    }


    /**
    * Checks if a user is a member of a community
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param Community $community
    * @since  [v1.0]
    * @return collection
    */
    public function isMemberOfCommunity($community, $ignoreSuperAdminStatus = false)
    {
        $communityCount = $this->communities()->where('community_id', '=', $community->id)->count();
        $superAdmin = $ignoreSuperAdminStatus ? false : $this->isSuperAdmin();
        $retValue = $communityCount || $superAdmin;
        //$yesNo = $retValue?'yes':'no';
        //LOG::debug("isMemberOfCommunity: ".$yesNo);

        return $retValue;
    }


    /**
    * Returns communities by user
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function getSlackUsername($community)
    {
        return $this->belongsToMany('App\User', 'communities_users', 'community_id', 'user_id')->withPivot('slack_name');
    }


    /**
     * Returns communities by user
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function getCustomLabelInCommunity($community)
    {
        $this_community = $this->communities()->where('community_id','=',$community->id)->first();
        if ($this_community) {
            return $this_community->pivot->custom_label;
        } else {
            return 'deleted';
        }

    }


    // a user has many requests
    public function getRequests($community)
    {
        return $this->hasMany('App\CommunityJoinRequests', 'communities_users', 'community_id', 'user_id');
    }


    /**
    * Returns the user full name, it simply concatenates
    * the user first and last name.
    *
    * @return string
    */
    public function getDisplayName()
    {

        if ($this->display_name) {
            return ucwords($this->display_name);
        } elseif (($this->first_name) && ($this->last_name)) {
            return "{$this->first_name} {$this->last_name}";
        } elseif ($this->first_name) {
            return $this->first_name;
        } else {
            return "Anonymous";
        }

    }


    /**
     * Gets conversations the user is involved in
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function conversations()
    {
        return $this->hasMany('\App\Conversation','started_by');
    }


    /**
    * Gets messages sent to user
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function messagesTo()
    {
		return $this->hasMany('\App\Message','sent_to');
    }


    /**
    * Get the count of unread messages
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
     * @param integer $limit
    * @return collection
    */
    public function getLimitedUnreadMessages() {
    	static $unread_cache;

    	if ($unread_cache) {
    		return $unread_cache;
    	} else {
			$unread_messages = Message::with('sender','conversation')
			->where('sent_to', '=', $this->id)
			->whereNull('read_on')
            ->orderBy('messages.created_at', 'DESC');

            $unread_messages = $unread_messages->take(5)->get();
			$unread_cache = $unread_messages;
			return $unread_messages;
    	}
    }


    /**
     * Get the count of unread messages
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @param integer $limit
     * @return collection
     */
    public function getUnreadMessagesCount() {
        static $unread_count_cache;

        if ($unread_count_cache) {
            return $unread_count_cache;
        } else {
            $unread_messages_count = Message::with('sender','conversation')
                ->where('sent_to', '=', $this->id)
                ->whereNull('read_on')->count();

            $unread_count_cache = $unread_messages_count;
            return $unread_messages_count;
        }
    }


    /**
    * Save the image to the DB. This method handles cover images, logos and profile images.
    *
    * @todo   Remove upload key, since it's not used here.
    * @author [D. Linnard] [<dslinnard@gmail.com>]
    * @since  [v1.0]
    * @return boolean
    */
    public static function saveImageToDB($user_id, $filename, $type, $id = null, $upload_key = null)
    {
        LOG::debug("User::saveImageToDB ".$user_id.", ".$filename.", ".$type);

        if ($user = User::find($user_id)) {
            $user->avatar_img = $filename;

            if (!$user->save()) {
                return false;
            }
        }

        return false;
    }


    /**
    * Deletes a users avatar
    *
    * @author [D. Linnard] [<david@linnard.com>]
    * @since  [v1.0]
    * @param int $user_id
    * @return boolean
    */
    public static function deleteAvatar($user_id)
    {
        if ($user = User::find($user_id)) {
            if ($user->avatar_img) {
                $filename = public_path().'/assets/uploads/users'.$user_id.'/'.$user->avatar_img;
                \File::Delete($filename);
                if (!\File::exists($filename))
                {
                    $user->avatar_img = null;
                    if ($user->save()) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
