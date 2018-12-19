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

    public function uploadImage(Models\User $user, UploadedFile $file, $layoutType, $rotation = null)
    {
        //log::debug("uploadImage entered: layoutType = ".$layoutType);
        $path = public_path() . '/assets/uploads/' . $layoutType . '/' . $this->id . '/';
        $aws_path = 'assets/uploads/' . $layoutType . '/' . $this->id;
        return self::moveAndStoreImage($user, $file, $path, $aws_path, $layoutType, $rotation, $this->id, null);
    }

    public static function uploadTmpImage(Models\User $user, UploadedFile $file, $layoutType, $upload_key, $rotation = null)
    {
        //log::debug("uploadTmpImage entered: layoutType = ".$layoutType);

        $path = public_path() . '/assets/uploads/' . $layoutType . '/user-' . $user->id . '-tmp';
        return self::moveAndStoreImage($user, $file, $path, null, $layoutType, $rotation, null, $upload_key);
    }

    /**
     * createThumbnailImage
     * Make a thumbnail version of this image
     *
     * @param string $img_path 
     *
     */

    public static function createThumbnailImage($name, $ext, $path, $layoutType, $id)
    {
        $filename = $name . '.' . $ext;
        $thumb = $name . '_thumb.' . $ext;
        $img_path = $path ."/". $filename;
        $thumb_path = $path . $thumb;

        //log::debug("createThumbnailImage: entered");
        // Only create the thumbnail once
        if (is_file(public_path().'/assets/uploads/' . $layoutType .'/' . $id . '/' . $thumb)) {
            return;
        }

        //log::debug("createThumbnailImage: thumb does not exist".$img_path);
        // open the current image
        if ($thumb = \Image::make($img_path)) {
            //log::debug("createThumbnailImage: made image from ".$img_path);

            // resize image
            $thumb->resize(self::$uploadableImgs[$layoutType]['thumb-width'], self::$uploadableImgs[$layoutType]['thumb-height'], function ($constraint) {
                    $constraint->aspectRatio();
                });
            $thumb->save($thumb_path);
            //echo "&nbsp;&nbsp;&nbsp;&nbsp;Entry " . $id . " has new thumbnail at " . $thumb_path . "<br><br>";
        }
    }

    /**
     * moveAndStoreImage
     *
     * $id can be community id, entry id or user_id
     *
     */
    public static function moveAndStoreImage(Models\User $user, UploadedFile $file, $path, $aws_path, $layoutType, $rotation, $id = null, $upload_key = null)
    {
        //log::debug("moveAndStoreImage: entered");
        // Make the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $rand_filename = str_random(10);
        $ext = $file->getClientOriginalExtension();
        $filename = $rand_filename . '.' . $ext;
        $img_path = $path . '/' . $filename;

        // move file to specified path and rename it to specified filename
        if ($file->move($path, $filename)) { 
            //log::debug("moveAndStoreImage: moved image to " . $path ."/". $filename);

            if ($id && $layoutType == 'entries') {
                //log::debug("moveAndStoreImage (entry exists) path = " . $path . ", filename = " . $filename . ", layoutType = " . $layoutType . ',  entry_id = ' . $id);

                $entry = Models\Entry::find($id);
                if (!empty($entry) && $entry->media()->count()) {
                    // We already have an image associated with an entry, so delete the existing image first
                    self::deleteImage($id, $user->id);
                    self::replaceImageInDB($user->id, $id, $filename);
                }
                else {
                    self::saveImageToDB($id, $filename, $layoutType, $user->id, $upload_key);
                }
            }
            else {
                // self::saveImageToDB can be Community (banner, logo), User (avatar), Enrty (entries)
                //log::debug("moveAndStoreImage (entry does not exist) path = " . $path . ", filename = " . $filename . ", layoutType = " . $layoutType . ',  id = ' . $id);
                self::saveImageToDB($id, $filename, $layoutType, $user->id, $upload_key);
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

                        if ('entries' == $layoutType) { // if it's an entry image then create a thumbnail
                            self::createThumbnailImage($rand_filename, $ext, $path, $layoutType, $id);
                        }
                        
                        // finally we save the image as a new file
                        $img->resize(self::$uploadableImgs[$layoutType]['width'], self::$uploadableImgs[$layoutType]['height'], function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->save($img_path, 100);
                    }
                } catch (Exception $e) {
                    log::error("Exception caught in moveAndStore Trait, in resize section: " . $e->getMessage());
                    return false;
                }
            }

            return $filename;
        }
        log::error("moveAndStoreImage moved filename failed, " . $filename);

        return false;
    }

    /**
     * rotate an image
     *
     * @author [D. Linnard] [<david@linnard.com>]
     * @param int    $user_id
     * @param int    $entry_id
     * @param string $layoutType
     * @param int    $rotation
     * @return bool
     * @since  [v1.0]
     */
    public static function rotateImage($user_id, $entry_id, $layoutType, $rotation)
    {
        if ($image = \DB::table('media')
            ->where('user_id', '=', $user_id)
            ->where('entry_id', '=', $entry_id)
            ->first()) {

            $file = public_path() . '/assets/uploads/entries/' . $entry_id . '/' . $image->filename;

            if (!Media::is_animated_gif($file)) {
                try {
                    if ($img = \Image::make($file)) { 
                        $img->rotate($rotation);
                        $img->save($file);
                        return true;
                    }
                } catch (Exception $e) {
                    log::error("Exception caught in rotateImage Trait: " . $e->getMessage());
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
            $file = public_path() . '/assets/uploads/entries/' . $entry_id . '/' . $image->filename;
            unlink($file);

            $path_parts = pathinfo('/assets/uploads/entries/' . $entry_id . '/' . $image->filename);
            $thumb = public_path().'/assets/uploads/entries/' . $entry_id . '/' . $path_parts['filename'] . '_thumb.' . $path_parts['extension'];

            if (is_file($thumb)) {
                unlink($thumb);
            }
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
        //log::debug("moveImagesForNewTile. " . $entry_id . ",  " . $upload_key);

        $tmp_images = \DB::table('media')
            ->where('upload_key', '=', $upload_key)
            ->where('user_id', '=', $user->id)
            ->get();

        $dest_path = public_path() . '/assets/uploads/entries/' . $entry_id;
        $src_path = public_path() . '/assets/uploads/entries/user-' . $user->id . '-tmp';

        foreach ($tmp_images as $tmp_image) {
            $filename = $tmp_image->filename;
            log::debug("moveImagesForNewTile. filename = " . $filename);
            $src = $src_path . '/' . $filename;
            $dest = $dest_path . '/' . $filename;

            // Make the directory if it doesn't exist
            if (!file_exists($dest_path)) {
                mkdir($dest_path, 0755, true);
            }

            $success = rename($src, $dest);

            if (!$success) {
                log::error("moveImagesForNewTile. Error renaming file from $src to $dest: " . $error);
                return false; // note only processing one image here before returning
            }

            // update the media entry
            //log::debug("moveImagesForNewTile. Success renaming file from $src to $dest");
            self::updateImageToDB($user->id, $upload_key, $entry_id);
        }
        return true;
    }
}
