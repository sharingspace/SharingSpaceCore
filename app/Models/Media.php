<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;


class Media extends Model
{

  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'media';

  /*
  * Model validation rules
  */
  protected $rules = [
      'file'      => 'image',
  ];


  public function entries() {
    return $this->belongsTo('App\Entry', 'entry_id');
  }


  public function uploadImage($fieldname = 'image', $type = 'profile', $width = 250, $height = null) {

		if (Input::hasFile($fieldname)) {
			$allFiles = Input::file();

			foreach($allFiles as $file)
			{
			$path = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/entries/'.$this->tile_id;
			$aws_path = 'assets/uploads/entries/'.$this->tile_id;

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

					}

  				$media = new Media();
  				$media->tile_id = $this->tile_id;
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
  					"Expires" => gmdate("D, d M Y H:i:s T", strtotime("+3 years"))
  				));



  				if (App::environment('staging','production')) {
  					unlink($img_path);
  				}

  				return true;

  			} else {
  				//echo "ERROR MOVING FILE!";
  				return false;
  			} // endif file moved

  		} // end foreach

		} else {
			return false;
		}// end if (Input::hasFile('image'))

	}


  /**
  * Thanks to ZeBadger for original example, and Davide Gualano for pointing me to it
  * Original at http://it.php.net/manual/en/function.imagecreatefromgif.php#59787
  **/
  public static function is_animated_gif( $filename )
  {
    $raw = file_get_contents( $filename );

    $offset = 0;
    $frames = 0;
    while ($frames < 2)
    {
      $where1 = strpos($raw, "\x00\x21\xF9\x04", $offset);
      if ( $where1 === false )
      {
        break;
      }
      else
      {
        $offset = $where1 + 1;
        $where2 = strpos( $raw, "\x00\x2C", $offset );
        if ( $where2 === false )
        {
          break;
        }
        else
        {
          if ( $where1 + 8 == $where2 )
          {
            $frames ++;
          }
          $offset = $where2 + 1;
        }
      }
    }

    return $frames > 1;
  }


}
