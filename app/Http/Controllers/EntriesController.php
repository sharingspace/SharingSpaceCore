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
    $entry->created_by	= Auth::user()->id;

    if (Input::get('location')) {
      $entry->location = e(Input::get('location'));
      $latlong = Helper::latlong(Input::get('location'));
    }

    if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
      $entry->latitude 		= $latlong['lat'];
      $entry->longitude 	= $latlong['lng'];
    }

    if ($entry->isInvalid()) {
			return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
		}


    if ($request->whitelabel_group->entries()->save($entry)) {
			$entry->exchangeTypes()->saveMany(\App\ExchangeType::all());
			return response()->json(['success'=>true, 'tile_id'=>$entry->id, 'title'=>$entry->title, 'post_type'=>$entry->post_type]);

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

    if (Input::get('location')) {
      $entry->location = e(Input::get('location'));
      $latlong = Helper::latlong(Input::get('location'));
    }

    if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
      $entry->latitude 		= $latlong['lat'];
      $entry->longitude 		= $latlong['lng'];
    }

		$ajaxAdd = e(Input::get('ajaxAdd'));

    if ($entry->isInvalid()) {
			if( $ajaxAdd ) {
				return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
			}
			else {
       return redirect()->back()->withInput()->withErrors($community->getErrors());
    }
    }

    if ($request->whitelabel_group->entries()->save($entry)) {
			$entry->exchangeTypes()->saveMany(\App\ExchangeType::all());
			if( $ajaxAdd ) {
			  return response()->json(['success'=>true, 'tile_id'=>$entry->id, 'title'=>$entry->title, 'post_type'=>$entry->post_type]);
			}

		} else {
      if( $ajaxAdd ) {
				return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
			}
			else {
      return redirect()->back()->with('error',trans('general.entries.messages.save_failed'));
    }
  }
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
	Save the entry edits
	*/
	public function postEdit(Request $request, $entryID)
	{

		  if ($entry = \App\Entry::find($entryID)) {

        $user = Auth::user();
				$ajaxAdd = e(Input::get('ajaxAdd'));

      	if (!$entry->checkUserCanEditEntry($user)) {
					if($ajaxAdd) {
						return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.not_allowed')]);
					}
					else {
			    return redirect()->route('browse')->with('error',trans('general.entries.messages.not_allowed'));
					}
      	} else {

          $entry->title	= e(Input::get('title'));
          $entry->post_type	= e(Input::get('post_type'));
          $entry->description	= e(Input::get('description'));
          $entry->qty	= e(Input::get('qty'));

          if (Input::get('location')) {
            $entry->location = e(Input::get('location'));
            $latlong = Helper::latlong(Input::get('location'));
          }

          if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
            $entry->latitude 		= $latlong['lat'];
            $entry->longitude 		= $latlong['lng'];
          }

          if (!$entry->save()) {

            if (Input::hasFile('file')) {
    					$filename 				=  Help::uploadImage('image', 'profile', 250, 250);
    				}

						if($ajaxAdd) {
							return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
						}
						else {
             return Redirect::back()->withInput()->withErrors($entry->getErrors());
          }
          }

					if( $ajaxAdd ) {
						return response()->json(['success'=>true,'entry_id'=>$entry->id,'title'=>$entry->title,'post_type'=>$entry->post_type]);
					}
					else {
          $entry->exchangeTypes()->sync(Input::get('entry_exchange_types'));

  				return redirect()->route('entry.view', $entry->id)->with('success',trans('general.entries.messages.save_edits'));
        }
        }

      } else {
				if($ajaxAdd) {
					return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.invalid')]);
				}
				else {
        return redirect()->route('browse')->with('error',trans('general.entries.messages.invalid'));
      }
      }

  }

	/*
  Delete the entry
  */
  public function postDelete($entryID)
  {
    if ($entry = \App\Entry::find($entryID)) {
      $user = Auth::user();
      if (!$entry->checkUserCanEditEntry($user)) {
        if($ajaxAdd) {
					return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.delete_not_allowed')]);
				}
				else {
					return redirect()->route('browse')->with('error',trans('general.entries.messages.delete_not_allowed'));
				}
      } else {
        if ($entry->delete()) {
					$ajaxAdd = e(Input::get('ajaxAdd'));
          $entry->exchangeTypes()->detach();
					if($ajaxAdd) {
						return response()->json(['success'=>true, 'entry_id'=>$entry->id]);
					}
					else {
          return redirect()->route('browse')->with('success',trans('general.entries.messages.deleted'));
					}
        } else {
          return redirect()->route('entry.view', $entry->id)->with('error',trans('general.entries.messages.delete_failed'));
        }
      }

    } else {
      return redirect()->route('browse')->with('error',trans('general.entries.messages.invalid'));
    }
  }


	/*
  * Process an uploaded image
  */
	public function ajaxUpload($entry_id = null) {
		if (Input::hasFile('image')) {

			if ($entry_id) {
				$tile = $this->tile->withTrashed()->find($entry_id);
				$filename =  $tile->uploadImage('image', 'profile', 250, 250);
			} else {
				$user = Sentry::getUser();
				$upload_key = Input::get('upload_key');
				$filename =  Tile::uploadTmpImage('image', 'profile', 250, 250, $upload_key);
			}

			 if ($filename) {
				return response()->json(['success'=>true, 'entry_id'=>$entry->id]);
			 } else {
				return response()->json(['success'=>false, 'entry_id'=>$entry->id]);
			 }

		} else {
			return response()->json(['success'=>false, 'entry_id'=>$entry->id, 'error'=>trans('general.entries.messages.invalid')]);
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
