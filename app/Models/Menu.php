<?php
/**
 * This model handles the relationships between users and their
 * social accounts.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    protected $fillable = ['name', 'page_id', 'order'];


    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'page_id', 'id');
    }
}
