<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;
use App\ExchangeTypes;
use Watson\Validating\ValidatingTrait;

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


  protected $rules = [
      'title'            => 'required|string|min:2|max:255',
      'post_type'            => 'required',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['title','post_type'];



  public function author() {
    return $this->belongsTo('App\User', 'created_by');
  }


  public function communities()
  {
    return $this->belongsToMany('App\Community', 'entries_hubgroup_join', 'entry_id', 'hubgroup_id');
  }

  public function exchangeTypes()
  {
      return $this->belongsToMany('App\ExchangeType', 'entries_exchange_types', 'entry_id', 'type_id');
  }



  /**
	* Convert the tags string to an array so we can loop through it and link to other results
	* on the tile display
	*/
  public function tagsToArray()
  {
		if ($this->tags!='') {
			$array = explode(",", $this->tags);
			return $array;
		}
  }


  public function media() {
      return $this->hasMany('App\Media', 'entry_id');
  }

  /*
  * Check whether this user can edit the entry
  * Admin checks can go here later as well
  */
  public  function checkUserCanEditEntry($user) {
      if ($user->id == $this->created_by) {
        return true;
      } else {
        return false;
      }

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


  public function uploadImage($fieldname = 'image', $type = 'profile', $width = 250, $height = null) {

		if (Input::hasFile($fieldname)) {
			$allFiles = Input::file();

			foreach($allFiles as $file)
			{
				$path = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/tiles/'.$this->tile_id;
				$aws_path = 'assets/uploads/tiles/'.$this->id;

				// Make the directory if it doesn't exist
				if (!file_exists($path)) {
					mkdir($path, 0755, true);
				}

				$filename = str_random(10).'.'.$file->getClientOriginalExtension();
				$orig_filename = str_random(10).'-orig.'.$file->getClientOriginalExtension();
				$img_path = $path.'/'.$filename;
	
				if ($file->move($path, $filename)) {

					if (App::environment('staging','production')) {
						$s3 = AWS::get('s3');
						$s3->putObject(array(
						'Bucket'     => Config::get('app.aws_bucket'),
						'Key'        => $aws_path.'/'.$orig_filename,
						'SourceFile' => $img_path,
						'CacheControl' => 'max-age=172800',
								"Expires" => gmdate("D, d M Y H:i:s T",
										strtotime("+3 years"))
						));
					}
	
					// check if it's an animated gif. If it is, don't resize it.
					if (!Media::is_animated_gif($img_path)) {
	
						try {
	
							if ($img = Image::make($img_path)) {
								if ($type=='profile') {
									$img->fit($width);
								} else {
									$img->fit($width, $height);
								}
	
								$img->save($img_path,70);
	
							} else {
								echo 'could not make file :(';
							}
	
						} catch (Exception $e) {
							//echo 'Caught exception: ',  $e->getMessage(), "\n";
						}
					} // animated gif

					$media = new Media();
					$media->entry_id = $this->id;
					$media->filename =  $filename;
					$media->filetype = 'image';
					$media->resized = 1;
					$media->caption = NULL;
					$media->created_at = date("Y-m-d H:i:s");
					$media->saveMedia();
	
					$s3 = AWS::get('s3');
					$s3->putObject(array(
						'Bucket'     => Config::get('app.aws_bucket'),
						'Key'        => $aws_path.'/'.$filename,
						'SourceFile' => $img_path,
						'CacheControl' => 'max-age=172800',
								"Expires" => gmdate("D, d M Y H:i:s T",
													strtotime("+3 years"))
					));

					if (App::environment('staging','production')) {
						unlink($img_path);
					}
					return true;
				} 
				else {
					//echo "ERROR MOVING FILE!";
					return false;
				} // endif file moved
			} // end foreach
		} 
		else {
			return false;
		}// end if (Input::hasFile('image'))
	}


	// TODO: Refactor this for DRY
	public static function uploadTmpImage($fieldname = 'image', $type = 'profile', $width = 250, $height = null, $upload_key = null) {

		if (Input::hasFile('image')) {

			foreach(Input::file('image') as $file) {
				$path = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/tiles/tmp/user-'.Sentry::getUser()->id.'/'.$upload_key;

				// Make the directory if it doesn't exist
				if (!file_exists($path)) {
					mkdir($path, 0755, true);
				}

				$filename = str_random(10).'.'.$file->getClientOriginalExtension();
				$orig_filename = str_random(10).'-orig.'.$file->getClientOriginalExtension();
				$img_path = $path.'/'.$filename;

				if ($file->move($path, $filename)) {
					// check if it's an animated gif. If it is, don't resize it.
					if (!Media::is_animated_gif($img_path)) {
						try {
	
							if ($img = Image::make($img_path)) {
								if ($type=='profile') {
									$img->fit($width);
								} else {
									$img->fit($width, $height);
								}
	
								$img->save($img_path,70);
	
	
							} else {
								echo 'could not make file :(';
							}
	
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
						}
					} // animated gif

					DB::table('tmp_media')->insert(
						array(
						'user_id' => Sentry::getUser()->id,
						'upload_key' => $upload_key,
						'filename' => $filename,
						'created_at' => date("Y-m-d H:i:s"))
					);

					return true;

				} else {
					return false;
				} // endif file moved
			} // end foreach
		} 
		else {
			return false;
		}// end if (Input::hasFile('image'))
	}
}
