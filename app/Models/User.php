<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use App\Social;
use App\CommunitySubscription;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cartalyst\Stripe\Billing\Laravel\Billable;
use Cartalyst\Stripe\Billing\Laravel\BillableContract;
use Watson\Validating\ValidatingTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, BillableContract, SluggableInterface
{
    use Authenticatable, CanResetPassword, Billable;
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
        'password' => 'required|min:6',
        'website'           => 'url',
        'fb_url'           => 'url',
        'twitter_url'      => 'url',
        'gplus_url'        => 'url',
        'pinterest_url'    => 'url',
        'youtube_url'      => 'url',
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


    /**
	* Returns the user Gravatar image url.
	*
	* @return string
	*/
	public function gravatar($size = null)
	{
		    return "//gravatar.com/avatar/".md5(strtolower(trim($this->email)))."";
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
      return $this->belongsToMany('Community', 'hubgroups_users','user_id','hubgroup_id');
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
