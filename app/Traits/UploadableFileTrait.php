<?php
namespace App;
use Symfony\Component\HttpFoundation\File\UploadedFile;


trait UploadableFileTrait {

  /**
  * Generic file upload trait.
  *
  * The $uploadableImgs array should be set on the model in order to use this
  * trait. See Entry model for example.
  *
  * @var boolean
  */

  public function uploadImage(\App\User $user, UploadedFile $file, $layoutType) {

    $path = base_path().'/public/assets/uploads/'.$layoutType.'/'.$this->id.'/';
    $aws_path = 'assets/uploads/'.$layoutType.'/'.$this->id;
    self::moveAndStoreImage($user, $file, $path, $aws_path, $layoutType, $this->id, null);

  }

  public static function uploadTmpImage(\App\User $user, UploadedFile $file, $layoutType, $upload_key) {
    $path = base_path().'/public/assets/uploads/'.$layoutType.'/user-'.$user->id.'-tmp';
    self::moveAndStoreImage($user, $file, $path, null, $layoutType, null, $upload_key);
  }

  public static function moveAndStoreImage(\App\User $user, UploadedFile $file, $path, $aws_path, $layoutType, $id = null, $upload_key = null) {

    // Make the directory if it doesn't exist
    if (!file_exists($path)) {
      mkdir($path, 0755, true);
    }

		$rand_filename = str_random(10);
    $filename = $rand_filename.'.'.$file->getClientOriginalExtension();

    $img_path = $path.'/'.$filename;

    if ($file->move($path, $filename)) { // $destinationPath, $fileName

      self::saveImageToDB($id, $filename, $layoutType, $user->id, $upload_key);

      if (!Media::is_animated_gif($img_path)) {

        try {

          if ($img = \Image::make($img_path)) {
            $img->fit(self::$uploadableImgs[$layoutType]['width'],self::$uploadableImgs[$layoutType]['height']);
            $img->save($img_path,70);
          }
          return false;

        } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
      }

      return true;

    }
    return false;
  }



		/**
	* This function does the cleanup after images have been uploaded to the tmp_media table and need to be associated with a
	* tile that's actually been saved.
	*/
	public static function moveImagesForNewTile(\App\User $user, $entry_id, $upload_key = null) {

		$tmp_images = \DB::table('media')
    ->where('upload_key','=', $upload_key)
		->where('user_id','=',  $user->id)
		->get();

		$aws_path = base_path().'/public/assets/uploads/entries/'.$user->id;
		$path = base_path().'/public/assets/uploads/entries/user-'.$user->id.'-tmp';
    
		foreach ($tmp_images as $tmp_image) {

			$filename = $tmp_image->filename;
			$src = $path.'/'.$filename;
      $dest = $aws_path.'/'.$filename;

      $error = rename($src, $dest);

      // update the media entry
      self::updateImageToDB($user->id, $upload_key, $entry_id);

      return $error; // note only processing one image here before returning
		}
	}
}
