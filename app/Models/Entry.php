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
  protected $table = 'tiles';
  protected $primaryKey = 'tile_id';

  public function author() {
    return $this->belongsTo('App\User', 'user_id');
  }


  public function communities()
  {
    return $this->belongsToMany('App\Community', 'tile_hubgroup_join', 'tile_id', 'hubgroup_id');
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
              $query->where('displayname','LIKE','%'.$search.'%');
          });
      });
  }


  public function exchangeTypesNames()
  {
      return $this->belongsToMany('App\Exchange', 'tile_exchange_types', 'tile_id', 'type_id');
  }

}
