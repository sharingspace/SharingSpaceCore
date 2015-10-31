<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiUserController extends Controller
{
  public function show($id)
  {
      return User::findOrFail($id);
  }

}
