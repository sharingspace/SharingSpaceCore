<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;
use App\Exchange;

class Entry extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'entries';

  // FIXME - This is poopy and not the right L5 way to do it
  public $rules = [
      'title'            => 'required|string|min:2|max:255',
  ];


  public function author() {
    return $this->belongsTo('App\User', 'created_by');
  }


  public function communities()
  {
    return $this->belongsToMany('App\Community', 'entries_hubgroup_join', 'entry_id', 'hubgroup_id');
  }


  public function exchangeTypesNames()
  {
      return $this->belongsToMany('App\Exchange', 'entries_exchange_types', 'entry_id', 'type_id');
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
