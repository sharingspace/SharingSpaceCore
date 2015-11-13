<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use App\Entry;
use Input;

class CommunitiesController extends Controller
{

  public function getHomepage()
  {

    if (Auth::check()) {
        // The user is logged in...
        $user = Auth::user();
        return view('home')->with('user',$user);
    }
    return view('home');

  }


  /*
  Get the entries view in current community
  */
  public function getEntriesView()
  {
    return view('browse');
  }


  /*
  Get the JSON list of entries in the current community
  */
  public function getEntriesDataView(Request $request)
  {
    $entries = $request->whitelabel_group->entries()->with('author');

    if (Input::has('search')) {
        $entries->TextSearch(e(Input::get('search')));
    }

    if (Input::has('offset')) {
        $offset = e(Input::get('offset'));
    } else {
        $offset = 0;
    }

    if (Input::has('limit')) {
        $limit = e(Input::get('limit'));
    } else {
        $limit = 50;
    }

    $order = Input::get('order') == 'asc' ? 'asc' : 'desc';
    $allowed_columns =
      [
        'title',
        'location',
        'created_at'
      ];

    $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
    $count = $entries->count();
    $entries = $entries->orderBy($sort, $order);
    $entries = $entries->skip($offset)->take($limit)->get();

    $rows = array();

    foreach ($entries as $entry) {

      $rows[] = array(
        'title' => $entry->title,
        'author' => $entry->author->displayname,
        'location' => $entry->location,
        'created_at' => $entry->created_at->format('M d Y g:iA'),
      );
    }

    $data = array('total' => $count, 'rows' => $rows);
    return $data;

  }

}
