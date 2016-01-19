<?php
namespace App;

trait UploadableFileTrait {

  /**
  * Generic file upload trait.
  *
  * The $uploadableImgs array should be set on the model in order to use this
  * trait. See Entry model for example.
  *
  * @var boolean
  */

  public function uploadImage($file, $layoutType) {

      $path = base_path().'/public/assets/uploads/'.$layoutType.'/'.$this->id.'/';
      $aws_path = 'assets/uploads/'.$layoutType.'/'.$this->id;

      // Make the directory if it doesn't exist
      if (!file_exists($path)) {
        mkdir($path, 0755, true);
      }

      $filename = str_random(10).'.'.$file->getClientOriginalExtension();
      $img_path = $path.'/'.$filename;
      $orig_filename = str_random(10).'-orig.'.$file->getClientOriginalExtension();

      if ($file->move($path, $filename)) {
        $media = new Media();
        $media->filename =  $filename;
        $media->filetype = 'image';
        $media->caption = NULL;
        $media->created_at = date("Y-m-d H:i:s");
        $media->save();

        if (!Media::is_animated_gif($img_path)) {

          try {

            if ($img = \Image::make($img_path)) {
              $img->fit($this->uploadableImgs[$layoutType]['width'],$this->uploadableImgs[$layoutType]['height']);
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
