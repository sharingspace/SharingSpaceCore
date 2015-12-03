<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Media extends Model
{

  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'media';


  public function entries() {
    return $this->belongsTo('App\Entry', 'entry_id');
  }


  /**
  * Thanks to ZeBadger for original example, and Davide Gualano for pointing me to it
  * Original at http://it.php.net/manual/en/function.imagecreatefromgif.php#59787
  **/
  public static function is_animated_gif( $filename )
  {
    $raw = file_get_contents( $filename );

    $offset = 0;
    $frames = 0;
    while ($frames < 2)
    {
      $where1 = strpos($raw, "\x00\x21\xF9\x04", $offset);
      if ( $where1 === false )
      {
        break;
      }
      else
      {
        $offset = $where1 + 1;
        $where2 = strpos( $raw, "\x00\x2C", $offset );
        if ( $where2 === false )
        {
          break;
        }
        else
        {
          if ( $where1 + 8 == $where2 )
          {
            $frames ++;
          }
          $offset = $where2 + 1;
        }
      }
    }

    return $frames > 1;
  }


}
