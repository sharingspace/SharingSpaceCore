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

  }
