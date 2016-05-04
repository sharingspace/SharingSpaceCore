<?php
/**
 * This contains some static helpers for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */

class Helper
{

    /**
    * Returns a CDN url
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return String
    */
    public static function cdn_assets($file)
    {
        static $manifest = null;

        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('build/rev-manifest.json')), true);
        }

        if (isset($manifest['assets/'.$file])) {
            $cdn_version_url = str_replace('/assets', '/', Config::get('services.cdn.default'));
            return $cdn_version_url.$manifest['assets/'.$file];

        } else {
            // This file is not in the versioned manifest, so just include it
            return Config::get('services.cdn.default').'/'.$file;
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }



    /**
    * Returns the latitude and longitude of an address
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return Array
    */
    public static function latlong($location)
    {
          //api call and JSON here

        if ($location!='') {
            try {
                $json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($location));
                $parsedjson = json_decode($json, true);

                if (key_exists(0, $parsedjson['results'])) {
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



    /**
    * Returns relative time, like "one day ago"
    *
    * @todo Use language files here instead of hardcoded english
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return String
    */
    public static function relativeTime($ts)
    {

        if (!ctype_digit($ts)) {
            $ts = strtotime($ts);
        }

        $diff = time() - $ts;
        if ($diff == 0) {
            return 'now';
        } elseif ($diff > 0) {
                $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 60) {
                    return 'just now';
                }
                if ($diff < 120) {
                    return '1 minute ago';
                }
                if ($diff < 3600) {
                    return floor($diff / 60) . ' minutes ago';
                }
                if ($diff < 7200) {
                    return '1 hour ago';
                }
                if ($diff < 86400) {
                    return floor($diff / 3600) . ' hours ago';
                }
            }
            if ($day_diff == 1) {
                return 'Yesterday';
            }
            if ($day_diff < 7) {
                return $day_diff . ' days ago';
            }
            if ($day_diff < 31) {
                return ceil($day_diff / 7) . ' weeks ago';
            }
            if ($day_diff < 60) {
                return 'last month';
            }
            return date('F Y', $ts);
        } else {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 120) {
                    return 'in a minute';
                }
                if ($diff < 3600) {
                    return 'in ' . floor($diff / 60) . ' minutes';
                }
                if ($diff < 7200) {
                    return 'in an hour';
                }
                if ($diff < 86400) {
                    return 'in ' . floor($diff / 3600) . ' hours';
                }
            }
            if ($day_diff == 1) {
                return 'Tomorrow';
            }
            if ($day_diff < 4) {
                return date('l', $ts);
            }
            if ($day_diff < 7 + (7 - date('w'))) {
                return 'next week';
            }
            if (ceil($day_diff / 7) < 4) {
                return 'in ' . ceil($day_diff / 7) . ' weeks';
            }
            if (date('n', $ts) == date('n') + 1) {
                return 'next month';
            }
            return date('F Y', $ts);
        }
    }
}
