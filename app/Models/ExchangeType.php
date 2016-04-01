<?php
/**
 * This model handles relationships for Exchange Types for
 * Entries and Communities in the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeType extends Model
{

    /**
  * The database table used by the model.
  *
  * @var string
  */
    protected $table = 'exchange_types';


    /**
    * Returns entries associated with an exchange type
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function entries()
    {
        return $this->belongsToMany('App\Entry', 'entries_exchange_types', 'entry_id', 'type_id');
    }

    /**
    * Return communities associated from their associated allowed exchange types.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function communities()
    {
        return $this->belongsToMany('App\Community', 'community_allowed_types', 'community_id', 'type_id');
    }
}
