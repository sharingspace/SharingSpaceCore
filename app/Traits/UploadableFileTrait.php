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

use App\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Log;
use Image;
use Redirect;

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

    public function uploadImage(Models\User $user, UploadedFile $file, $layoutType, $rotation=null)
    {
        $path = public_path().'/assets/uploads/'.$layoutType.'/'.$this->id.'/';
        $aws_path = 'assets/uploads/'.$layoutType.'/'.$this->id;
        return self::moveAndStoreImage($user, $file, $path, $aws_path, $layoutType, $rotation, $this->id, null);
    }

    public static function uploadTmpImage(Models\User $user, UploadedFile $file, $layoutType, $upload_key, $rotation=null)
    {
        LOG::debug("uploadTmpImage entered");

        $path = public_path().'/assets/uploads/'.$layoutType.'/user-'.$user->id.'-tmp';
        return self::moveAndStoreImage($user, $file, $path, null, $layoutType, $rotation, null, $upload_key );
    }

    /**
    * moveAndStoreImage
    *
    * $id can be community id, entry id or user_id
    *
    */
    public static function moveAndStoreImage(Models\User $user, UploadedFile $file, $path, $aws_path, $layoutType, $rotation, $id=null, $upload_key = null)
    {
        // Make the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $rand_filename = str_random(10);
        $filename = $rand_filename.'.'.$file->getClientOriginalExtension();

        $img_path = $path.'/'.$filename;
        
        if ($file->move($path, $filename)) { // $destinationPath, $fileName

            if ($id && $layoutType =='entries') {
                LOG::debug("moveAndStoreImage moved path = ".$path.", filename = ".$filename.", layoutType = ".$layoutType.',  entry_id = '.$id);

                $entry = Models\Entry::find($id);
                if (!empty($entry) && $entry->media()->count())
                {
                    // We already have an image associated with an entry, so delete the existing image first
                    self::deleteImage($id, $user->id);
                    self::replaceImageInDB($user->id, $id, $filename);
                }
                else {
                    $res = self::saveImageToDB($id, $filename, $layoutType, $user->id, $upload_key);

                }
            }
            else {
                // self::saveImageToDB can be Community (banner, logo), User (avatar), Enrty (entries)
                LOG::debug("moveAndStoreImage moved path = ".$path.", filename = ".$filename.", layoutType = ".$layoutType.',  id = '.$id);
                $res = self::saveImageToDB($id, $filename, $layoutType, $user->id, $upload_key);
            }

            if (!Media::is_animated_gif($img_path)) {

                try {

                    if ($img = \Image::make($img_path)) {
                        if ($rotation) {
                            if (is_numeric($rotation)) {
                                $img->rotate($rotation);
                            }
                            else {
                                return false;
                            }
                        }

                        // finally we save the image as a new file
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
        LOG::debug("moveAndStoreImage moved filename failed, ".$filename);

        return false;
    }

    /**
    * rotate an image
    *
    * @author [D. Linnard] [<david@linnard.com>]
    * @param int $user_id
    * @param int $entry_id
    * @param string $layoutType
    * @param int $rotation
    * @return bool
    * @since  [v1.0]
    */   
    public static function rotateImage($user_id, $entry_id, $layoutType, $rotation)
    {
        if ($image = \DB::table('media')
            ->where('user_id', '=', $user_id)
            ->where('entry_id', '=', $entry_id)
            ->first()) {
            
            $file = public_path().'/assets/uploads/entries/'.$entry_id.'/'.$image->filename;
                
            if (!Media::is_animated_gif($file)) {
                try {
                    if ($img = \Image::make($file)) {
                        $img->rotate($rotation);
                        $img->save($file);
                        return true;
                    }
                }
                catch (Exception $e) {
                    Log::error("Exception caught in rotateImage Trait: ".$e->getMessage());
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                    return false;
                }
            }
        }
        return false;

    }

   /**
    * Deletes an image
    *
    * @author [D. Linnard] [<david@linnard.com>]
    * @since  [v1.0]
    */

    public static function deleteImage($entry_id, $user_id)
    {
        if ($image = \DB::table('media')
            ->where('user_id', '=', $user_id)
            ->where('entry_id', '=', $entry_id)
            ->first()) {
            $file = public_path().'/assets/uploads/entries/'.$entry_id.'/'.$image->filename;
            unlink($file);

        }
        return false;
    }


    /**
    * This function does the cleanup after images have been uploaded
    * to the tmp_media table and need to be associated with a
    * tile that's actually been saved.
    */
    public static function moveImagesForNewTile(Models\User $user, $entry_id, $upload_key = null)
    {
        Log::debug("moveImagesForNewTile. ".$entry_id.",  ".$upload_key);

        $tmp_images = \DB::table('media')
            ->where('upload_key', '=', $upload_key)
            ->where('user_id', '=', $user->id)
            ->get();

        $dest_path = public_path().'/assets/uploads/entries/'.$entry_id;
        $src_path = public_path().'/assets/uploads/entries/user-'.$user->id.'-tmp';

        foreach ($tmp_images as $tmp_image) {
            $filename = $tmp_image->filename;
            Log::debug("moveImagesForNewTile. filename = ".$filename);
            $src = $src_path.'/'.$filename;
            $dest = $dest_path.'/'.$filename;

            // Make the directory if it doesn't exist
            if (!file_exists($dest_path)) {
                mkdir($dest_path, 0755, true);
            }

            $success = rename($src, $dest);

            if (!$success) {
                Log::error("moveImagesForNewTile. Error renaming file from $src to $dest: ".$error);
                return false; // note only processing one image here before returning
            }

            // update the media entry
            Log::error("moveImagesForNewTile. Success renaming file from $src to $dest");
            self::updateImageToDB($user->id, $upload_key, $entry_id);
        }
        return true;
    }
}
