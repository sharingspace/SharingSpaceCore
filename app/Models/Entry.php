<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;

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

}
