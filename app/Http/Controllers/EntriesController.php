<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use Validator;
use Input;
use Redirect;
use Helper;

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
      return redirect()->route('browse')->with('error',trans('general.entries.messages.invalid'));
    }

  }


  /*
  Get the create entry page
  */
  public function getCreate()
  {
    return view('entries.create');
  }


  /*
  * Save new entry via Ajax
  */
  public function postAjaxCreate(Request $request)
  {
    $entry = new \App\Entry();
    $entry->title	= e(Input::get('title'));
    $entry->post_type	= e(Input::get('post_type'));
		$entry->description	= e(Input::get('description'));
    $entry->created_by	= Auth::user()->id;
    $entry->tags	= e(Input::get('tags'));
    $entry->qty	= e(Input::get('qty'));

    if (Input::get('location')) {
      $entry->location = e(Input::get('location'));
      $latlong = Helper::latlong(Input::get('location'));
    }

    if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
      $entry->latitude 		= $latlong['lat'];
      $entry->longitude 	= $latlong['lng'];
    }

    if ($entry->isInvalid()) {
			return response()->json(['success'=>false, 'error'=>$entry->getErrors()]);
		}


    if ($request->whitelabel_group->entries()->save($entry)) {
			$entry->exchangeTypes()->sync(Input::get('exchange_types'));
      $types=[]; //FIXME this is broken. Sorry. I don't know why it doesn't work.

      foreach($entry->exchangeTypes as $et) {
        array_push($types,$et->name);
      }
			return response()->json(['success'=>true, 'entry_id'=>$entry->id, 'title'=>$entry->title, 'description'=>$entry->description, 'post_type'=>$entry->post_type,'qty'=>$entry->qty,'exchange_types' =>$types]);

		}

    return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);

  }



  /*
  * Save new entry
  */
  public function postCreate(Request $request)
  {
    $entry = new \App\Entry();
    $entry->title	= e(Input::get('title'));
    $entry->post_type	= e(Input::get('post_type'));
    $entry->created_by	= Auth::user()->id;
    $entry->tags	= e(Input::get('tags'));
    $entry->qty	= e(Input::get('qty'));

    if (Input::get('location')) {
      $entry->location = e(Input::get('location'));
      $latlong = Helper::latlong(Input::get('location'));
    }

    if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
      $entry->latitude 		= $latlong['lat'];
      $entry->longitude 		= $latlong['lng'];
    }

    if ($entry->isInvalid()) {
       return redirect()->back()->withInput()->withErrors($entry->getErrors());
    }

    if ($request->whitelabel_group->entries()->save($entry)) {

      if (Input::hasFile('file')) {
        $entry->uploadImage(Auth::user(),Input::file('file'), 'entries');
      }

      $entry->exchangeTypes()->sync(Input::get('exchange_types'));

			return response()->json(['success'=>true, 'tile_id'=>$entry->id, 'title'=>$entry->title, 'post_type'=>$entry->post_type, 'exchange_types'=>Input::get('exchange_types')]);

		}
      return redirect()->back()->with('error',trans('general.entries.messages.save_failed'));

  }

	/*
	Edit the entry
	*/
	public function getEdit($entryID)
	{
      // This should be pulled into a helper or macro
      $post_types = array('want'=>'I want', 'have'=>'I have');

		  if ($entry = \App\Entry::find($entryID)) {

        $user = Auth::user();

        if (!$entry->checkUserCanEditEntry($user)) {
          return redirect()->route('browse')->with('error',trans('general.entries.messages.not_allowed'));

        } else {
          return view('entries.edit')->with('entry',$entry)->with('post_types',$post_types);
        }

      } else {
        return redirect()->route('browse')->with('error',trans('general.entries.messages.invalid'));
      }

  }


  /*
  Save the entry edits via Ajax
  */
  public function postAjaxEdit(Request $request, $entryID)
  {

      if ($entry = \App\Entry::find($entryID)) {

        $user = Auth::user();

        if (!$entry->checkUserCanEditEntry($user)) {
          return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.not_allowed')]);
        }

        $entry->title	= e(Input::get('title'));
        $entry->post_type	= e(Input::get('post_type'));
        $entry->description	= e(Input::get('description'));
        $entry->qty	= e(Input::get('qty'));
        $entry->tags	= e(Input::get('tags'));

        if (Input::get('location')) {
          $entry->location = e(Input::get('location'));
          $latlong = Helper::latlong(Input::get('location'));
        }

        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
          $entry->latitude 		  = $latlong['lat'];
          $entry->longitude 		= $latlong['lng'];
        }

        if (!$entry->save()) {
          return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
        }

        if (Input::hasFile('file')) {
          $entry->uploadImage(Auth::user(),Input::file('file'), 'entries');
        }

        $entry->exchangeTypes()->sync(Input::get('exchange_types'));
        return response()->json(['success'=>true,'entry_id'=>$entry->id,'qty'=>$entry->qty,'title'=>$entry->title,'post_type'=>$entry->post_type]);

      }

      return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.invalid')]);

  }



  /*
	Save the entry edits
	*/
	public function postEdit(Request $request, $entryID)
	{

	  if ($entry = \App\Entry::find($entryID)) {

      $user = Auth::user();

    	if (!$entry->checkUserCanEditEntry($user)) {
		    return redirect()->route('browse')->with('error',trans('general.entries.messages.not_allowed'));
    	} else {

        $entry->title	= e(Input::get('title'));
        $entry->post_type	= e(Input::get('post_type'));
        $entry->description	= e(Input::get('description'));
        $entry->qty	= e(Input::get('qty'));
        $entry->tags	= e(Input::get('tags'));

        if (Input::get('location')) {
          $entry->location = e(Input::get('location'));
          $latlong = Helper::latlong(Input::get('location'));
        }

        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
          $entry->latitude 		= $latlong['lat'];
          $entry->longitude 		= $latlong['lng'];
        }

        if (!$entry->save()) {
           return Redirect::back()->withInput()->withErrors($entry->getErrors());
        }

        if (Input::hasFile('file')) {
          $entry->uploadImage(Auth::user(),Input::file('file'), 'entries');
        }
        $entry->exchangeTypes()->sync(Input::get('exchange_types'));

				return redirect()->route('entry.view', $entry->id)->with('success',trans('general.entries.messages.save_edits'));
      }

    }
    return redirect()->route('browse')->with('error',trans('general.entries.messages.invalid'));

  }


  /*
  Delete the entry via Ajax
  */
  public function postAjaxDelete($entryID)
  {
    if ($entry = \App\Entry::find($entryID)) {
      $user = Auth::user();

      if (!$entry->checkUserCanEditEntry($user)) {
        return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.delete_not_allowed')]);
      } else {

        if ($entry->delete()) {
          $entry->exchangeTypes()->detach();
          return response()->json(['success'=>true, 'entry_id'=>$entry->id]);
        }

        return redirect()->route('entry.view', $entry->id)->with('error',trans('general.entries.messages.delete_failed'));
      }
    }

    return redirect()->route('browse')->with('error',trans('general.entries.messages.invalid'));

  }


	/*
  Delete the entry
  */
  public function postDelete($entryID)
  {
    if ($entry = \App\Entry::find($entryID)) {
      $user = Auth::user();

      if (!$entry->checkUserCanEditEntry($user)) {
				return redirect()->route('browse')->with('error',trans('general.entries.messages.delete_not_allowed'));
      } else {
        if ($entry->delete()) {
          $entry->exchangeTypes()->detach();
          return redirect()->route('browse')->with('success',trans('general.entries.messages.deleted'));
        }
        return redirect()->route('entry.view', $entry->id)->with('error',trans('general.entries.messages.delete_failed'));
      }

    }
    return redirect()->route('browse')->with('error',trans('general.entries.messages.invalid'));

  }


	/*
  * Process an uploaded image
  */
	public function ajaxUpload($entryID = null) {

		if (Input::hasFile('image')) {

      if ($entryID) {

        $entry = \App\Entry::find($entryID);

        if (!$entry->checkUserCanEditEntry($user)) {
          return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.edit_not_allowed')]);
        } else {
          $uploaded = $entry->uploadImage(Auth::user(), Input::file('file'), 'entries');
        }

      } else {
        $uploaded = Entry::uploadTmpImage(Auth::user(), Input::file('file'), 'entries', Input::get('upload_key'));
      }

      // The file was uploaded successfully
      if ($uploaded) {
        return response()->json(['success'=>true, 'entry_id'=>$entry->id]);
      }

      return response()->json(['success'=>false, 'entry_id'=>$entry->id]);
		}
		return response()->json(['success'=>false, 'entry_id'=>$entry->id, 'error'=>trans('general.entries.messages.invalid')]);

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

    $allowed_columns =
      [
        'title',
        'location',
        'post_type',
        'created_at'
      ];

    $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
    $order = Input::get('order') == 'asc' ? 'asc' : 'desc';

    $count = $entries->count();
    $entries = $entries->orderBy($sort, $order);
    $entries = $entries->skip($offset)->take($limit)->get();

    $rows = array();

    if (Auth::check()) {
      $user = Auth::user();
    } else {
      $user = null;
    }

    foreach ($entries as $entry) {

      $actions = '';

        if (($user) && ($entry->deleted_at=='') && ($entry->checkUserCanEditEntry($user))) {
            $actions = '<a href="'.route('entry.edit.form', $entry->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a><a href="'.route('entry.delete.save', $entry->id).'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
        } else {
            $actions = '';
        }


      $rows[] = array(
        'title' => '<a href="'.route('entry.view', $entry->id).'">'.$entry->title.'</a>',
        'post_type' => strtoupper($entry->post_type),
        'author' => '<a href="'.route('user.profile', $entry->author->id).'">'.$entry->author->getDisplayName().'</a>',
        'location' => $entry->location,
        'created_at' => $entry->created_at->format('M d Y g:iA'),
        'actions' => $actions,
      );
    }

    $data = array('total' => $count, 'rows' => $rows);
    return $data;

  }


}
