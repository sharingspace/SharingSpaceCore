<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

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

}
