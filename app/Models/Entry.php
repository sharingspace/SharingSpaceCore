<?php
/**
 * This model handles relationships for Entries in
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */

namespace App\Models;

use App\Collection;
use App\Illuminate\Database\Query\Builder;
use App\no;
use App\text;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use App\UploadableFileTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

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
        'title'     => 'required|string|min:3|max:255',
        'post_type' => 'required',
        'qty'       => 'required|numeric|min:1',
    ];

    /**
     * Append mutated attributes to the Array and JSON casting.
     *
     * @var array
     */
    protected $appends = ['latitude', 'longitude'];

    /*
    * Set traits for uploadable image
    */

    public static $uploadableImgs = [
        'entries' => [
            'height' => '600',
            'width'  => '600',
        ],
    ];

    public static $tagList = [
        'art supplies',
        'ecology',
        'skills',
        'learning opportunities',
        'building resources',
        'meet a neighbor',
        'free',
        'upcycle projects',
        'dreams',
    ];

    protected $dates = ['deleted_at', 'expires', 'completed_at'];

    protected $casts = [
        'enabled' => 'boolean',
        'visible' => 'boolean',
        'wrld3d'  => 'collection',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'post_type', 'qty', 'lat', 'lng', 'wrld3d'];

    /**
     * Return the author of an entry
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    /**
     * Returns the communities the entry belongs to.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function communities()
    {
        return $this->belongsToMany('App\Models\Community', 'entries_community_join', 'entry_id', 'community_id');
    }

    /**
     * Returns the entry's exchange types.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function exchangeTypes()
    {
        return $this->belongsToMany('App\Models\ExchangeType', 'entries_exchange_types', 'entry_id', 'type_id');
    }

    /**
     * @return mixed
     */
    public function getLatitudeAttribute()
    {
        return $this->lat;
    }

    /**
     * Set the lat attribute when code tries to change latitude attribute.
     *
     * @param $value
     */
    public function setLatitudeAttribute($value)
    {
        $this->attributes['lat'] = $value;
    }

    /**
     * @return mixed
     */
    public function getLongitudeAttribute()
    {
        return $this->lng;
    }

    /**
     * Set the lng attribute when code tries to update longitude attribute.
     *
     * @param $value
     */
    public function setLongitudeAttribute($value)
    {
        $this->attributes['lng'] = $value;
    }

    public function getNaturalPostTypeAttribute()
    {
        return ($this->post_type == 'want') ? 'wants' : 'has';
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlAttribute()
    {
        return url('/entry/' . $this->getKey());
    }

    /**
     * Static method to save an entry image to the database.
     *
     * @todo   Add AWS integration
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int    $id
     * @param string $filename
     * @param string $type
     * @param int    $user_id
     * @param string $upload_key
     * @since  [v1.0]
     * @return mixed
     */
    public static function saveImageToDB($entry_id, $filename, $type, $user_id, $upload_key = null)
    {
        LOG::debug('Entry::saveImageToDB entry_id = ' . $entry_id . ', filename = ' . $filename . ', type = ' . $type . ', user_id = ' . $user_id . ', upload_key = ' . $upload_key);

        $media = new Media();
        $media->entry_id = $entry_id;
        $media->upload_key = $upload_key;
        $media->filename = $filename;
        $media->filetype = 'image';
        $media->caption = null;
        $media->created_at = date('Y-m-d H:i:s');
        $media->user_id = $user_id;

        return $media->save();
    }

    /**
     * Updates the image entry in the database to reflect the new entry ID.
     * This is necessary because the quick add AJAX form allows you to upload images
     * to a new entry before the entry actually exists and has an ID number.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @param int    $user_id
     * @param string $upload_key
     * @param int    $entry_id
     * @return mixed
     */
    public static function updateImageToDB($user_id, $upload_key, $entry_id)
    {
        Log::error('Entry::updateImageToDB user_id = ' . $user_id . ', upload_key = ' . $upload_key . ', entry_id = ' . $entry_id);

        $media = \App\Models\Media::where('upload_key', '=', $upload_key)
            ->where('user_id', '=', $user_id)
            ->first();

        $media->entry_id = $entry_id;
        $media->save();
    }

    /**
     * Replaces the image entry in the database to reflect the new entry ID.
     * This function is used to impose a limit of one image per entry.
     *
     * @author [D. Linnard] [<david@linnard.com>]
     * @since  [v1.0]
     * @param int    $user_id
     * @param int    $entry_id
     * @param string $filename
     * @return no return
     */
    public static function replaceImageInDB($user_id, $entry_id, $filename)
    {
        $media = \App\Models\Media::where('user_id', '=', $user_id)
            ->where('entry_id', '=', $entry_id)
            ->first();

        $media->filename = $filename;
        $media->save();
    }

    /**
     * Deletes entry image.
     *
     * @author [D. Linnard] [<david@linnard.com>]
     * @since  [v1.0]
     * @param int $user_id
     * @param int $entry_id
     * @return no return
     */
    public static function deleteImageFromDB($entry_id, $user_id)
    {
        $media = \App\Models\Media::where('entry_id', '=', $entry_id)
            ->where('user_id', '=', $user_id)
            ->first();

        if ($media) {
            $media->delete();
        }
    }

    /**
     * Converts a string of tags into an array
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return array
     */
    public function tagsToArray()
    {
        if ($this->tags != '') {
            $array = explode(',', $this->tags);
            return $array;
        }
    }

    /**
     * Returns the media associated with an entry.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function media()
    {
        return $this->hasMany('App\Models\Media', 'entry_id');
    }

    /**
     * Check whether this user can edit the entry
     * Admin checks can go here later as well
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @param object $user
     * @return boolean
     */
    public function checkUserCanEditEntry($user)
    {
        if ($user->id == $this->created_by) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Query builder scope to only return uncompleted
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @param Builder $query  Query builder instance
     * @param text    $search Search term
     * @return Builder          Modified query builder
     */
    public function scopeNotCompleted($query)
    {
        return $query->whereNull('completed_at');
    }

    /**
     * Query builder scope to search on text
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @param Builder $query  Query builder instance
     * @param text    $search Search term
     * @return Builder          Modified query builder
     */
    public function scopeTextSearch($query, $search)
    {
        return $query->where('title', 'LIKE', "%$search%")
            ->orWhere('location', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->orWhere('tags', 'LIKE', "%$search%")
            ->orWhere(
                function ($query) use ($search) {
                    $query->whereHas(
                        'author',
                        function ($query) use ($search) {
                            $query->where('display_name', 'LIKE', '%' . $search . '%');
                        }
                    );
                }
            );
    }

    /**
     * Does the user own this entry?
     *
     * @author [D. Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return boolean
     */
    public function isOwnedBy($user)
    {
        return $this->created_by === $user->id;
    }

    /**
     * Does it have a WRLD3D POI created?
     *
     * @return bool
     */
    public function hasWrldPoi()
    {
        return $this->wrld3d && $this->wrld3d->get('poi_id');
    }

    /**
     * Does it have latitude and longitude?
     *
     * @return bool
     */
    public function hasGeolocation()
    {
        return $this->lat && $this->lng;
    }

    /**
     * Query builder scope to search on tag text
     *
     * @author [D. Linnard] [<david@linnard.com>]
     * @since  [v1.0]
     * @param Builder $query  Query builder instance
     * @param text    $search Search term
     * @return Builder          Modified query builder
     */
    public static function scopeTagSearch($query, $search)
    {
        return $query->where('tags', 'LIKE', "%$search%")->where('visible', 1)->NotCompleted();
    }
}
