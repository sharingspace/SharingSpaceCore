<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;
use App\Exchange;

class Community extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'communities';

  // FIXME - This is poopy and not the right L5 way to do it
  public $rules = [
      'name'            => 'required|string|min:2|max:255',
      'subdomain'            => 'required|alpha_dash|min:2|max:255',
  ];


  public function owner() {
      return $this->belongsTo('App\User', 'created_by');
  }

  /**
   * Relationship for entries and communities
   *
   * @return collection
   */
  public function entries() {
    return $this->belongsToMany('App\Entry', 'entries_community_join', 'community_id', 'entry_id');
  }


  /**
  * Get the members of a group.
  * Groups belong to many users by way of the communities_users table.
  *
  * @return collection
  */
  public function members()
  {
   	return $this->belongsToMany('App\User', 'communities_users', 'community_id', 'user_id')->withPivot('is_admin');
  }

  /**
  * Get the cover image url based on app environment
  *
  * @return string
  */
  public function getCover() {

		if ($this->cover_img!='') {
			$cover_img = Config::get('services.cdn.default').'/uploads/communities/'.$this->community_id.'/'.$this->cover_img;
		} else {
			$cover_img = Config::get('services.cdn.default').'/img/covers/default-heart-cover.jpg';
		}
		return $cover_img;
	}


  /**
  * Get the logo image url based on app environment
  *
  * @return string
  */
  public function getLogo() {

		if ($this->logo) {
			return Config::get('services.cdn.default').'/uploads/communities/'.$this->community_id.'/'.$this->logo;
		} else {
			return null;
		}
	}

  /**
  * Get the profile image url based on app environment
  *
  * @return string
  */
	public function getProfileImg() {

		if ($this->profile_img) {
			return Config::get('app.cdn.default').'/uploads/communities/'.$this->community_id.'/'.$this->profile_img;
		} else {
			return null;
		}
	}


  /**
  * Get the exchnage types allowed in this community.
  * Exchange Types belong to many communities by way of the group_allowed_types table.
  *
  * @return collection
  */
	public function exchange_types()
    {
    	$exchanges = $this->belongsToMany('App\Exchange', 'community_allowed_types', 'community_id', 'type_id')->withTimestamps();
    	return $exchanges;
    }


  /**
   * scopeEntriesInCommunity
   * Get all entries that are in the current community
   *
   * @param       $query
   * @param array $categoryIdListing
   *
   * @return mixed
   * @version v1.0
   */
  public function scopeEntriesInCommunity($query)
  {
      return $query->whereIn( 'category_id', $categoryIdListing );
  }


}
