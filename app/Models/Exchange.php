<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Entry;
use App\Community;

class Exchange extends Model
{

  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'exchange_types';

  public function exchange()
	{
		return $this->belongsToMany('App\Entry', 'exchange_types', 'entry_id', 'type_id');
	}

	public function communities()
	{
		return $this->belongsToMany('App\Community', 'type_id', 'community_id');
	}

	public static function getExchangeTypes() {
		//$exchanges = Exchange::get()	}
	}
}
