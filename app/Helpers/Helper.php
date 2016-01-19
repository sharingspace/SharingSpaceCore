<?php


  class Helper
  {

      public static function cdn_assets($file)
      {
          static $manifest = null;

          if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('build/rev-manifest.json')), true);
          }

          if (isset($manifest['assets/'.$file])) {
            $cdn_version_url = str_replace('/assets','/',Config::get('services.cdn.default'));
            return $cdn_version_url.$manifest['assets/'.$file];

          } else {
            // This file is not in the versioned manifest, so just include it
            return Config::get('services.cdn.default').'/'.$file;
          }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
      }

      public static function  latlong($location) {
       		//api call and JSON here

       		if ($location!='') {
       			try {
    				$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($location));
    				$parsedjson = json_decode($json, true);

    				if (key_exists(0,$parsedjson['results'])) {
    					$lat_long_array = $parsedjson['results'][0]['geometry']['location'];
    					return $lat_long_array;
    				} else {
    					return false;
    				}
    			} catch (Exception $e) {
        			//echo 'Caught exception: ',  $e->getMessage(), "\n";
        			return false;
    			}
    		}
    	}



      public function uploadImage($entry, $fieldname = 'image', $type = 'profile', $width = 250, $height = null) {

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
                  "Expires" => gmdate("D, d M Y H:i:s T",
                            strtotime("+3 years"))
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


  }
