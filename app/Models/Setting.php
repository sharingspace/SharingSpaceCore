<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use Watson\Validating\ValidatingTrait;
use Log;

class Setting extends Model
{

    /**
  * The database table used by the model.
  *
  * @var string
  */
    protected $table = 'settings';

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

    ];

  

}
