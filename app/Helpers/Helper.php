<?php


  class Helper
  {

      public static function cdn_assets($file, $type = 'css')
      {
          static $manifest = null;

          if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('build/rev-manifest.json')), true);
          }

          if (isset($manifest[$file])) {
            return Config::get('services.cdn.default').'/build/'.$manifest[$file];
          } else {
            return Config::get('services.cdn.default').'/'.$file;
          }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
      }

  }
