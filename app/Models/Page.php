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

class Page extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    protected $fillable = ['title', 'body', 'slug', 'meta_description', 'meta_keywords', 'status'];
}
