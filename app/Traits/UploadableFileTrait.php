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
    $path = base_path().'/public/assets/uploads/'.$layoutType.'/user-'.$user->id.'-tmp/';
    self::moveAndStoreImage($user, $file, $path, $aws_path, $layoutType, null, $upload_key);
  }

  public static function moveAndStoreImage(\App\User $user, UploadedFile $file, $path, $aws_path, $layoutType, $id = null, $upload_key = null) {

    // Make the directory if it doesn't exist
    if (!file_exists($path)) {
      mkdir($path, 0755, true);
    }

    $filename = str_random(10).'.'.$file->getClientOriginalExtension();
    $img_path = $path.'/'.$filename;
    $orig_filename = str_random(10).'-orig.'.$file->getClientOriginalExtension();

    if ($file->move($path, $filename)) {
      $media = new Media();
      $media->entry_id = $id;
      //$media->upload_key = $upload_key;
      $media->filename =  $filename;
      $media->filetype = 'image';
      $media->caption = NULL;
      $media->created_at = date("Y-m-d H:i:s");
      $media->save();

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

}
