<?php

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
use App\Social;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, BillableContract, SluggableInterface
{
    use Authenticatable, CanResetPassword, Billable, Authorizable;
    use SluggableTrait;
    use ValidatingTrait;


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


    public function subscriptions() {
        return $this->hasMany('App\CommunitySubscription', 'billable_id');
    }


    public function social() {
        return $this->hasMany('App\Social', 'user_id');
    }

    public function isSuperAdmin() {
        if ($this->superadmin=='1') {
            return true;
        } else {
            return false;
        }
    }

    public function isAdminOfCommunity($community)
    {
      return $this->communities('\App\Models\Community', 'communities_users', 'community_id', 'user_id')->where('community_id', '=', $community->id)->where('is_admin','=','1')->count() > 0;
    }


    public function canAdmin($community)
    {
      if (($this->isAdminOfCommunity($community)) ||  ($this->isSuperAdmin())) {
          return true;
      } else {
          return false;
      }
    }

    public function canSeeCommunity($community)
    {
      if ((($this->isMemberOfCommunity($community)) || ($this->isSuperAdmin())) ||   ($community->group_type!='S')) {
          return true;
      } else {
          return false;
      }
    }



    /**
	* Returns the user Gravatar image url.
	*
	* @return string
	*/
	public function gravatar($size = null)
	{
		if($this->gravatar) {
			return "/assets/uploads/users/".$this->id."/".$this->gravatar;
		}
		else {
		  return "//gravatar.com/avatar/".md5(strtolower(trim($this->email)))."?d=http%3A%2F%2Fanysha.re%2Fassets%2Fimg%2Fdefault%2Favatar.jpg' )";
		}
	}


  /*
  * Get social accounts associated with this user
  */
  public static function saveSocialAccount($socialUser, $provider) {

      // Check to see if a user exists in the users table first
      $user =  User::where('email', '=', $socialUser->getEmail())->first();

       // There is NOT a matching email address in the user table
       if (!$user) {
           $user = new User;
           $user->email = $socialUser->getEmail();
           $user->first_name = $socialUser->getName();
           if (!$user->save()) {
               return false;
           }
       }

      $social = $user->social()->firstOrNew
          (
          ['user_id' => $user->id,
          'service'=>$provider,
          'uid' => $socialUser->getId()
          ]);

          $social->access_token = $socialUser->token;
          $social->save();


      return $user;


  }

  /*
  * Check whether they have social logins stored
  */
  public static function checkForSocialLoginDBRecord($user, $provider) {
      return DB::table( 'social' )
       ->where( 'access_token', '=', $user->token )
       ->where('service','=',$provider)
       ->get();

  }

  /**
   * @param array $data
   * @return User
   */
  public static function register($data = [])
  {
      return static::create($data);
  }


  public function communities()
  {
      return $this->belongsToMany('\App\Community', 'communities_users','user_id','community_id');
  }


  public function isMemberOfCommunity($community)
  {
    return $this->communities('\App\Models\Community', 'communities_users', 'community_id', 'user_id')->where('community_id', '=', $community->id)->count() > 0;
  }

  public function getSlackUsername($community) {
      return $this->belongsToMany('App\User', 'communities_users', 'community_id', 'user_id')->withPivot('slack_name');
  }

  /**
  * Returns the user full name, it simply concatenates
  * the user first and last name.
  *
  * @return string
  */
  public function getDisplayName()
  {

    if ($this->display_name){
      return ucwords($this->display_name);
    } elseif (($this->first_name) && ($this->last_name)){
    	 return "{$this->first_name} {$this->last_name}";
    } elseif ($this->first_name){
    	 return $this->first_name;
    } else {
    	 return "Anonymous";
    }

  }
}
