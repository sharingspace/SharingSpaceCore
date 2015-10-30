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

		if ($this->cover_img) {
			$cover_img = Config::get('app.cdn.insecure').'/uploads/hubgroups/'.$this->hubgroup_id.'/'.$this->cover_img;
		} else {
			if($whiteLabel) {
				$cover_img = Config::get('app.cdn.default').'/img/whitelabel/banner.jpg';
			} else {
				$cover_img = Config::get('app.cdn.default').'/img/mosaic_banner.jpg';
			}
		}
		return $cover_img;
	}

}
