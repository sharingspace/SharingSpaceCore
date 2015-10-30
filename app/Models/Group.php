<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Config;

class Group extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'hubgroups';
  protected $primaryKey = 'hubgroup_id';

  public function user() {
      return $this->belongsTo('User', 'user_id');
  }


  /* Groups belong to many users by way of the hubgroups_users table */
  public function members()
  {
   	return $this->belongsToMany('User', 'hubgroups_users', 'hubgroup_id', 'user_id');
  }

  public function getCover() {

		if ($this->cover_img!='') {
			$cover_img = Config::get('services.cdn.default').'/uploads/hubgroups/'.$this->hubgroup_id.'/'.$this->cover_img;
		} else {
			$cover_img = Config::get('services.cdn.default').'/img/whitelabel/banner.jpg';
		}
		return $cover_img;
	}



  public function getLogo() {

		if ($this->logo) {
			return Config::get('services.cdn.default').'/uploads/hubgroups/'.$this->hubgroup_id.'/'.$this->logo;
		} else {
			return null;
		}
	}

	public function getProfileImg() {

		if ($this->profile_img) {
			return Config::get('app.cdn.default').'/uploads/hubgroups/'.$this->hubgroup_id.'/'.$this->profile_img;
		} else {
			return null;
		}
	}

}
