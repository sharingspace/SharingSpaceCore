<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use Validator;
use Input;
use Redirect;

class EntriesController extends Controller
{

  /*
  Get the create entry page
  */
  public function getEntry($entryID)
  {
    if ($entry = \App\Entry::find($entryID)) {
      return view('entries.view')->with('entry',$entry);
    } else {
      return view('browse')->with('error',trans('general.entries.messages.invalid'));
    }

  }


  /*
  Get the create entry page
  */
  public function getCreate()
  {
    return view('entries.edit');
  }

  /*
  * Save new entry
  */
  public function postCreate(Request $request)
  {
    $entry = new \App\Entry();
    $validator = Validator::make(Input::all(), $entry->rules);

    if ($validator->fails()) {
      return Redirect::back()->withInput()->withErrors($validator->messages());
    } else {

      $entry->title	= e(Input::get('title'));
      $entry->post_type	= e(Input::get('post_type'));
      $entry->created_by	= Auth::user()->id;

      if ($request->whitelabel_group->entries()->save($entry)) {
				return response()->json(['success'=>true, 'tile_id'=>$entry->id, 'title'=>$entry->title, 'post_type'=>$entry->post_type]);			
				
			//	return Response::json(['success'=>true,'tile_id'=>$tile->tile_id,'title'=>$tile->title,'post_type'=>$tile->post_type,'hubNames'=>$hubNames,'location'=>$tile->location,'tile_exchange_types'=>$tileExchangeTypesNames]);
			} else {
        return Redirect::back()->with('error',trans('general.entries.messages.save_failed'));
      }

    }
  }
	
	/*
	Edit the entry
	*/
	public function postEdit($entryID)
	{
		
  }

	/*
  Delete the entry
  */
  public function getDelete($entryID)
  {
    
  }


	/*
  * Process an uploaded image
  */
	public function ajaxUpload($tile_id = null) {
		if (Input::hasFile('image')) {
	
			if ($tile_id) {
				$tile = $this->tile->withTrashed()->find($tile_id);
				$filename =  $tile->uploadImage('image', 'profile', 250, 250);
			} else {
				$user = Sentry::getUser();
				$upload_key = Input::get('upload_key');
				$filename =  Tile::uploadTmpImage('image', 'profile', 250, 250, $upload_key);
			}
	
			 if ($filename) {
				return Response::json('success', 200);
			 } else {
				return Response::json('error - unknown', 400);
			 }
	
		} else {
			return Response::json('error - no image', 400);
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
        'post_type',
        'created_at'
      ];

    $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
    $count = $entries->count();
    $entries = $entries->orderBy($sort, $order);
    $entries = $entries->skip($offset)->take($limit)->get();

    $rows = array();

    foreach ($entries as $entry) {

      $rows[] = array(
        'title' => '<a href="'.route('entry.view', $entry->id).'">'.$entry->title.'</a>',
        'post_type' => strtoupper($entry->post_type),
        'author' => '<a href="'.route('user.profile', $entry->author->id).'">'.$entry->author->getDisplayName().'</a>',
        'location' => $entry->location,
        'created_at' => $entry->created_at->format('M d Y g:iA'),
      );
    }

    $data = array('total' => $count, 'rows' => $rows);
    return $data;

  }


}
