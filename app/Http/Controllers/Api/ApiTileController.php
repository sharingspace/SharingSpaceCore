<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class ApiTileController extends Controller
{
  public function show($id)
  {
      return Tile::findOrFail($id);
  }

}
