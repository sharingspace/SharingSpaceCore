<?php
/**
 * This model handles relationships for Media files
 * in the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */

namespace App\Models;

use App\App;
use App\AWS;
use App\Collection;
use App\Exception;
use App\Image;
use App\Input;
use Illuminate\Database\Eloquent\Model;

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
        'file' => 'image|nullable',
    ];


    /**
     * Returns a collection of entries by media type
     *
     * @todo   Is this actually used? Confirm and delete if not.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return collection
     */
    public function entries()
    {
        return $this->belongsTo('App\Models\Entry', 'entry_id');
    }


    /**
     * Return the author of an entry
     *
     * @todo       Remove this method.
     * @author     [A. Gianotto] [<snipe@snipe.net>]
     * @since      [v1.0]
     * @param string $fieldname
     * @param string $type
     * @param int    $width
     * @param null   $height
     * @return bool
     * @deprecated We do not use this anymore. Use UploadableFileTrait instead.
     */
    public function uploadImage_old($fieldname = 'image', $type = 'profile', $width = 250, $height = null)
    {

        if (Input::hasFile($fieldname)) {
            $allFiles = Input::file();

            foreach ($allFiles as $file) {
                $path = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/entries/' . $this->tile_id;
                $aws_path = 'assets/uploads/entries/' . $this->tile_id;

                // Make the directory if it doesn't exist
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $filename = str_random(10) . '.' . $file->getClientOriginalExtension();
                $orig_filename = str_random(10) . '-orig.' . $file->getClientOriginalExtension();
                $img_path = $path . '/' . $filename;

                if ($file->move($path, $filename)) {

                    if (App::environment('staging', 'production')) {
                        $s3 = AWS::get('s3');
                        $s3->putObject(
                            array(
                                'Bucket'       => config('app.aws_bucket'),
                                'Key'          => $aws_path . '/' . $orig_filename,
                                'SourceFile'   => $img_path,
                                'CacheControl' => 'max-age=172800',
                                "Expires"      => gmdate(
                                    "D, d M Y H:i:s T",
                                    strtotime("+3 years")
                                ),
                            )
                        );
                    }

                    // check if it's an animated gif. If it is, don't resize it.
                    if (!Media::is_animated_gif($img_path)) {

                        try {
                            if ($img = Image::make($img_path)) {
                                if ($type == 'profile') {
                                    $img->fit($width);
                                }
                                else {
                                    $img->fit($width, $height);
                                }
                                $img->save($img_path, 70);
                            }
                            else {
                                echo 'could not make file :(';
                            }
                        } catch (Exception $e) {
                            //echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                    }

                    $media = new Media();
                    $media->tile_id = $this->tile_id;
                    $media->filename = $filename;
                    $media->filetype = 'image';
                    $media->resized = 1;
                    $media->caption = null;
                    $media->created_at = date("Y-m-d H:i:s");
                    $media->saveMedia();

                    $s3 = AWS::get('s3');
                    $s3->putObject(
                        array(
                            'Bucket'       => config('app.aws_bucket'),
                            'Key'          => $aws_path . '/' . $filename,
                            'SourceFile'   => $img_path,
                            'CacheControl' => 'max-age=172800',
                            "Expires"      => gmdate("D, d M Y H:i:s T", strtotime("+3 years")),
                        )
                    );

                    if (App::environment('staging', 'production')) {
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


    /**
     * Determines if the image is an animated gif or not.
     * We can't resize animated gifs, so this lets us know if we can
     * safely resize the image.
     *
     * @link   http://it.php.net/manual/en/function.imagecreatefromgif.php#59787
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return boolean
     */

    public static function is_animated_gif($filename)
    {
        $raw = file_get_contents($filename);

        $offset = 0;
        $frames = 0;
        while ($frames < 2) {
            $where1 = strpos($raw, "\x00\x21\xF9\x04", $offset);
            if ($where1 === false) {
                break;
            }
            else {
                $offset = $where1 + 1;
                $where2 = strpos($raw, "\x00\x2C", $offset);
                if ($where2 === false) {
                    break;
                }
                else {
                    if ($where1 + 8 == $where2) {
                        $frames++;
                    }
                    $offset = $where2 + 1;
                }
            }
        }

        return $frames > 1;
    }
}
