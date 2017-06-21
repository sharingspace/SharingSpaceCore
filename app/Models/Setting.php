<?php
/**
 * This model is just used to establish the table name.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Models;

use Config;
use Illuminate\Database\Eloquent\Model;
use Log;
use Watson\Validating\ValidatingTrait;

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
