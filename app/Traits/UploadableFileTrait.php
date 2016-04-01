<?php
/**
 * This Trait handles uploading files throughout the system.
 *
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Log;

trait UploadableFileTrait
{

    /**
    * Generic file upload trait.
    *
    * The $uploadableImgs array should be set on the model in order to use this
    * trait. See Entry model for example.
    *
    * In the model:
    *
    * public static $uploadableImgs = [
    * 'entries' =>
    *   [
    *   'height' => '250',
    *   'width' => '250',
    *   ],
    * ];
    *
    * @var boolean
    */

    public function uploadImage(\App\User $user, UploadedFile $file, $layoutType)
    {
        $path = public_path().'/assets/uploads/'.$layoutType.'/'.$this->id.'/';
        $aws_path = 'assets/uploads/'.$layoutType.'/'.$this->id;
        self::moveAndStoreImage($user, $file, $path, $aws_path, $layoutType, $this->id, null);
    }

    public static function uploadTmpImage(\App\User $user, UploadedFile $file, $layoutType, $upload_key)
    {
        $path = public_path().'/assets/uploads/'.$layoutType.'/user-'.$user->id.'-tmp';
        return self::moveAndStoreImage($user, $file, $path, null, $layoutType, null, $upload_key);
    }

    public static function moveAndStoreImage(\App\User $user, UploadedFile $file, $path, $aws_path, $layoutType, $id = null, $upload_key = null)
    {

      // Make the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $rand_filename = str_random(10);
        $filename = $rand_filename.'.'.$file->getClientOriginalExtension();

        $img_path = $path.'/'.$filename;

        if ($file->move($path, $filename)) { // $destinationPath, $fileName
          //Log::debug("We were able to move file from $path to $filename!");
            $res = self::saveImageToDB($id, $filename, $layoutType, $user->id, $upload_key);
          //Log::debug("The results of saving to the DB, though, are: $res");

            if (!Media::is_animated_gif($img_path)) {
              //Log::info("This is *NOT* an animated GIF, so try this...");

                try {

                    if ($img = \Image::make($img_path)) {
                        $img->resize(self::$uploadableImgs[$layoutType]['width'], self::$uploadableImgs[$layoutType]['height'], function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->save($img_path, 100);
                    }
                } catch (Exception $e) {
                    Log::error("Exception caught in moveAndStore Trait, in resize section: ".$e->getMessage());
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                    return false;
                }
            }

            return $filename;

        }
        return false;
    }



    /**
    * This function does the cleanup after images have been uploaded
    * to the tmp_media table and need to be associated with a
    * tile that's actually been saved.
    */
    public static function moveImagesForNewTile(\App\User $user, $entry_id, $upload_key = null)
    {

        $tmp_images = \DB::table('media')
        ->where('upload_key', '=', $upload_key)
        ->where('user_id', '=', $user->id)
        ->get();

        $dest_path = public_path().'/assets/uploads/entries/'.$entry_id;
        $src_path = public_path().'/assets/uploads/entries/user-'.$user->id.'-tmp';

        foreach ($tmp_images as $tmp_image) {
            // Log::debug("okay, looking at one tmp image to migrate...".$tmp_image->filename);

            $filename = $tmp_image->filename;
            $src = $src_path.'/'.$filename;
            $dest = $dest_path.'/'.$filename;

            // Make the directory if it doesn't exist
            if (!file_exists($dest_path)) {
                mkdir($dest_path, 0755, true);
            }

            $success = rename($src, $dest);

            if (!$success) {
                Log::error("Error renaming file from $src to $dest: ".$error);
                return false; // note only processing one image here before returning
            }

            // update the media entry
            self::updateImageToDB($user->id, $upload_key, $entry_id);


        }
        return true;
    }
}
