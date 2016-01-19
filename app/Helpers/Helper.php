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




  }
