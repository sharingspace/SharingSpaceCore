<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;
use App\ExchangeTypes;
use Watson\Validating\ValidatingTrait;

class Entry extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'entries';

  /**
  * Whether the model should inject it's identifier to the unique
  * validation rules before attempting validation. If this property
  * is not set in the model it will default to true.
  *
  * @var boolean
  */
  protected $injectUniqueIdentifier = true;


  use ValidatingTrait;


  protected $rules = [
      'title'            => 'required|string|min:2|max:255',
      'post_type'            => 'required',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['title'];



  public function author() {
    return $this->belongsTo('App\User', 'created_by');
  }


  public function communities()
  {
    return $this->belongsToMany('App\Community', 'entries_hubgroup_join', 'entry_id', 'hubgroup_id');
  }

  public function exchangeTypes()
  {
      return $this->belongsToMany('App\ExchangeType', 'entries_exchange_types', 'entry_id', 'type_id');
  }



  /**
	* Convert the tags string to an array so we can loop through it and link to other results
	* on the tile display
	*/
  public function tagsToArray()
  {
		if ($this->tags!='') {
			$array = explode(",", $this->tags);
			return $array;
		}
  }


  public function media() {
      return $this->hasMany('App\Media', 'entry_id');
  }

  /*
  * Check whether this user can edit the entry
  * Admin checks can go here later as well
  */
  public  function checkUserCanEditEntry($user) {
      if ($user->id == $this->created_by) {
        return true;
      } else {
        return false;
      }

  }


  /**
  * Query builder scope to search on text
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  * @param  text                              $search      Search term
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
  public function scopeTextSearch($query, $search)
  {

    return $query->where('title', 'LIKE', "%$search%")
      ->orWhere('location', 'LIKE', "%$search%")
      ->orWhere(function($query) use ($search) {
          $query->whereHas('author', function($query) use ($search) {
              $query->where('display_name','LIKE','%'.$search.'%');
          });
      });
  }




}
