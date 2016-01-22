<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;
use App\ExchangeTypes;
use Watson\Validating\ValidatingTrait;
use App\UploadableFileTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

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
  use UploadableFileTrait;
  use SoftDeletes;

  /*
  * Model validation rules
  */
  protected $rules = [
      'title'            => 'required|string|min:3|max:255',
      'post_type'        => 'required',
      'qty'              => 'required|numeric|min:1',
  ];

  /*
  * Set traits for uploadable image
  */

  public static $uploadableImgs = [
      'entries' =>
        [
          'height' => '250',
          'width' => '250',
        ],
  ];


  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['title','post_type','qty'];



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


  public static function saveImageToDB($id, $filename, $type, $upload_key = null) {
    $media = new Media();
    $media->entry_id = $id;
    $media->upload_key = $upload_key;
    $media->filename =  $filename;
    $media->filetype = 'image';
    $media->caption = NULL;
    $media->created_at = date("Y-m-d H:i:s");
    $media->save();
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
