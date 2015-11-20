<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;

class EntriesController extends Controller
{
  /*
  Get the create entry page
  */
  public function getCreate()
  {
    return view('entries.edit');
  }

  /*
  * Save new community
  */
  public function postCreate(Request $request)
  {
    $entry = new \App\Entry();
    $validator = Validator::make(Input::all(), $entry->rules);

    if ($validator->fails()) {
      return Redirect::back()->withInput()->withErrors($validator->messages());
    } else {

      $entry->name	= e(Input::get('name'));

      if ($entry->save()) {
        return redirect('/browse')->with('success','Success!');

      }

    }
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
        'author' => $entry->author->getDisplayName(),
        'location' => $entry->location,
        'created_at' => $entry->created_at->format('M d Y g:iA'),
      );
    }

    $data = array('total' => $count, 'rows' => $rows);
    return $data;

  }


}
