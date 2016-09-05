<?php
/**
 * This controller handles all actions related to Entries for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use Validator;
use Input;
use Redirect;
use Helper;
use Log;
use Gate;
use App\Entry;

class EntriesController extends Controller
{

    /**
    * Returns a view that displays entry information
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return View
    */
    public function getEntry(Request $request, $entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {
            if ($request->user()->cannot('view-entry', $request->whitelabel_group)) {
                return redirect()->route('browse')->with('error', trans('general.entries.messages.not_allowed'));
            }

            $images = \DB::table('media')
              ->where('entry_id', '=', $entryID)
              ->get();

            return view('entries.view')->with('entry', $entry)->with('images', $images);

        } else {
          return redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
        }
    }

    public function ajaxGetEntry(Request $request, $entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {
            $imageName=null;

            if ($request->user()->cannot('view-entry', $request->whitelabel_group)) {
              return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.not_allowed')]);
            }

            $types=[]; 
            $typeIds=[];
             foreach ($entry->exchangeTypes as $et) {
                array_push($types, $et->name);
                array_push($typeIds,$et->id);
            }

            $image = \DB::table('media')
              ->where('entry_id', '=', $entryID)
              ->first();

            if ($image) {
              $imageName = $image->filename;
            }

            return response()->json(['success'=>true, 'entry_id'=>$entry->id,'title'=>$entry->title, 'description'=>$entry->description, 'post_type'=>$entry->post_type, 'qty'=>$entry->qty,'exchange_types' =>$types,'exchange_type_ids' => $typeIds, 'tags' => $entry->tags, 'location'=>$entry->location, 'visible'=>$entry->visible, 'image'=>$imageName]);            

        }
        else {
          redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
        }
    }


    /**
    * Returns a view that makes a form to create a new entry
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    EntriesControllers::postCreate()
    * @since  [v1.0]
    * @return View
    */
    public function getCreate(Request $request)
    {
        $post_types = array('want'=>'I want', 'have'=>'I have');

        $request->session()->put('upload_key', str_random(15));
        return view('entries.create')->with('post_types', $post_types);
    }


    /**
    * Validates and stores the new entry data via AJAX request.
    *
    * @author [David Linnard] [<dslinnard@gmail.com>]
    * @since  [v1.0]
    * @return String JSON
    */
    public function postAjaxCreate(Request $request)
    {
        $entry = new \App\Entry();
        
        $entry->title    = e(Input::get('title'));
        $entry->post_type    = e(Input::get('post_type'));
        $entry->description    = e(Input::get('description'));
        $entry->created_by    = Auth::user()->id;
        $entry->tags    = e(Input::get('tags'));
        $entry->qty    = e(Input::get('qty'));
        $upload_key = e(Input::get('upload_key'));
        $entry->visible = e(Input::get('private')) ? 0 : 1;
        $exchange_types = Input::get('exchange_types');

        $validator = Validator::make($request->all(), $entry->getRules());
        if ($validator->fails()) {
          return response()->json(['success'=>false, 'errors'=>$validator->messages()]);
        }

        if (empty($exchange_types)) {
            return response()->json(['success'=>false, 'error'=>trans("general.entries.messages.no_exchange_types")]);
        }

        if (Input::get('location')) {
            $entry->location = e(Input::get('location'));
            $latlong = Helper::latlong(Input::get('location'));
        }

        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
            $entry->latitude = $latlong['lat'];
            $entry->longitude = $latlong['lng'];
        }

        if ($request->whitelabel_group->entries()->save($entry)) {
            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            $types=$typeIds=[];

            foreach ($entry->exchangeTypes as $et) {
                array_push($types, $et->name);
                array_push($typeIds,$et->id);
            }
            $uploaded = true;

            if (Input::hasFile('file')) {
                Log::debug("We have a file - and, weirdly, kinda shouldn't?");
                $rotation=null;
                if (!empty(Input::get('rotation'))) {
                    $rotation = Input::get('rotation');
                }

                if (!$entry->uploadImage(Auth::user(), Input::file('file'), 'entries', $rotation)) {
                    return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.rotation_failed')]);
                }
            } else {
                $uploaded = \App\Entry::moveImagesForNewTile(Auth::user(), $entry->id, $upload_key);
            }

            if ($uploaded) {
                return response()->json(['success'=>true, 'create'=>true, 'entry_id'=>$entry->id, 'title'=>$entry->title, 'description'=>$entry->description, 'post_type'=>$entry->post_type,'qty'=>$entry->qty,'exchange_types' =>$types, 'tags' => $entry->tags, 'typeIds' => $typeIds]);
            } else {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.upload_failed')]);
            }
        }

        return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
    }



    /**
    * Validates and stores the new entry.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    EntriesController::getCreate()
    * @since  [v1.0]
    * @return Redirect
    */
    /*
    public function postCreate(Request $request)
    {
        $entry = new \App\Entry();
        $entry->title    = e(Input::get('title'));
        $entry->post_type    = e(Input::get('post_type'));
        $entry->created_by    = Auth::user()->id;
        $entry->tags    = e(Input::get('tags'));
        $entry->qty    = e(Input::get('qty'));

        if (Input::get('location')) {
            $entry->location = e(Input::get('location'));
            $latlong = Helper::latlong(Input::get('location'));
        }

        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
            $entry->latitude         = $latlong['lat'];
            $entry->longitude         = $latlong['lng'];
        }

        if ($entry->isInvalid()) {
            return redirect()->back()->withInput()->withErrors($entry->getErrors());
        }

        if ($request->whitelabel_group->entries()->save($entry)) {

            // Check if there is a file being uploaded
            if (Input::hasFile('file')) {
                // if the file was uploaded correctly
                if ($entry->uploadImage(Auth::user(), Input::file('file'), 'entries')) {

                    if (!\App\Entry::moveImagesForNewTile(Auth::user(), $request->session()->get('upload_key'))) {
                        return response()->json(['success'=>false]);
                    }
                    return response()->json(['success'=>false]);
                }
            }

            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            return response()->json(['success'=>true, 'tile_id'=>$entry->id, 'title'=>$entry->title, 'post_type'=>$entry->post_type, 'exchange_types'=>Input::get('exchange_types')]);

        }
        return redirect()->back()->with('error', trans('general.entries.messages.save_failed'));

    }*/

    /**
    * Returns a form view to edit an entry
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    EntriesController::postEdit()
    * @since  [v1.0]
    * @return View
    */
    public function getEdit(Request $request, $entryID)
    {
        // This should be pulled into a helper or macro
        $post_types = array('want'=>'I want', 'have'=>'I have');

        if ($entry = \App\Entry::find($entryID)) {

            $user = Auth::user();

            if ($request->user()->cannot('update-entry', $entry)) {
                return redirect()->route('browse')->with('error', trans('general.entries.messages.not_allowed'));
            }

            $image = \DB::table('media')
            ->where('entry_id', '=', $entryID)
            ->first();

            if ($image) {
                $imageName = $image->filename;
            }
            else {
                $imageName = null;
            }

            $selected_exchange_types = $entry->exchangeTypes;

            foreach ($selected_exchange_types as $selected_exchange_type) {
                $selected_exchanges[$selected_exchange_type->id] = $selected_exchange_type->id;
            }
            return view('entries.edit')->with('entry', $entry)->with('post_types', $post_types)->with('selected_exchanges', $selected_exchanges)->with('image',$imageName);

        }
        else {
            return redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
        }
    }


    /**
    * Validates and stores the entry edits submitted via AJAX.
    *
    * @author [David Linnard] [<dslinnard@gmail.com>]
    * @since  [v1.0]
    * @return String JSON
    */
    public function postAjaxEdit(Request $request, $entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {
            $user = Auth::user();

            if ($request->user()->cannot('update-entry', $entry)) {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.not_allowed')]);
            }

            $entry->title = e(Input::get('title'));
            $entry->post_type = e(Input::get('post_type'));
            $entry->description = e(Input::get('description'));
            $entry->qty = e(Input::get('qty'));
            $entry->tags = e(Input::get('tags'));
            $entry->visible = e(Input::get('private')) ? 0 : 1;

            if (Input::get('location')) {
                $entry->location = e(Input::get('location'));
                $latlong = Helper::latlong(Input::get('location'));
            }

            if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
                $entry->latitude = $latlong['lat'];
                $entry->longitude = $latlong['lng'];
            }

            if (!$entry->save()) {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
            }

            if (Input::hasFile('file')) {
                $entry->uploadImage(Auth::user(), Input::file('file'), 'entries', $rotation);
            }
            else if(Input::has('deleteImage')) {
                \App\Entry::deleteImage($entry->id, $user->id);
                \App\Entry::deleteImageFromDB($entry->id, $user->id);
            }
            else if(Input::has('rotation')) {
                if(!\App\Entry::rotateImage($user->id, $entry->id, 'entries', (int)Input::get('rotation'))) {
                  return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
                }
            }

            $types=[]; 
            $typeIds=[];
            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            foreach ($entry->exchangeTypes as $et) {
                array_push($types, $et->name);
                array_push($typeIds,$et->id);
            }

            return response()->json(['success'=>true, 'create'=>false, 'entry_id'=>$entry->id,'title'=>$entry->title, 'description'=>$entry->description, 'post_type'=>$entry->post_type, 'qty'=>$entry->qty,'exchange_types' =>$types,'typeIds' => $typeIds, 'tags' => $entry->tags]);
        }

        return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.invalid')]);
    }



    /**
    * Validates and stores the entry edits.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    EntriesController::getEdit()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postEdit(Request $request, $entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {

            $user = Auth::user();

            if ($request->user()->cannot('update-entry', $entry)) {
                abort(403);
            }

            $entry->title    = e(Input::get('title'));
            $entry->post_type    = e(Input::get('post_type'));
            $entry->description    = e(Input::get('description'));
            $entry->qty    = e(Input::get('qty'));
            $entry->tags    = e(Input::get('tags'));
            $entry->visible = e(Input::get('private')) ? 0 : 1;

            if (Input::get('location')) {
                $entry->location = e(Input::get('location'));
                $latlong = Helper::latlong(Input::get('location'));
            }

            if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
                $entry->latitude         = $latlong['lat'];
                $entry->longitude         = $latlong['lng'];
            }

            if (!$entry->save()) {
                return Redirect::back()->withInput()->withErrors($entry->getErrors());
            }

            if (Input::hasFile('file')) {
                if (!empty(Input::get('rotation') && Input::get('rotation'))) {
                    $entry->uploadImage(Auth::user(), Input::file('file'), 'entries', Input::get('rotation'));
                }
                else {
                    $entry->uploadImage(Auth::user(), Input::file('file'), 'entries');
                }
            }
            else if(Input::get('deleteImage')) {
                \App\Entry::deleteImage($entry->id, $user->id);
                \App\Entry::deleteImageFromDB($entry->id, $user->id);
            } else if (Input::get('rotation')) {
              if(!\App\Entry::rotateImage($user->id, $entry->id, 'entries', (int)Input::get('rotation'))) {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
              }
            }
            
            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            return redirect()->route('entry.view', $entry->id)->with('success', trans('general.entries.messages.save_edits'));
        }

        return redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
    }


    /**
    * Deletes an entry via AJAX request
    *
    * @todo   Consolidate this and the non-ajax delete.
    * @author [David Linnard] [<dslinnard@gmail.com>]
    * @since  [v1.0]
    * @return String JSON
    */
    public function postAjaxDelete($entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {
            $user = Auth::user();

            if (!$entry->checkUserCanEditEntry($user)) {
                return response()->json(['success'=>false, 'message'=>trans('general.entries.messages.delete_not_allowed')]);
            }
            else {
                if ($entry->delete()) {
                    $entry->exchangeTypes()->detach();
                    return response()->json(['success'=>true, 'entry_id'=>$entry->id, 'message'=>trans('general.entries.messages.delete_success')]);
                }
                return response()->json(['success'=>false, 'message'=>trans('general.entries.messages.delete_failed')]);
            }
        }
        return response()->json(['success'=>false, 'message'=>trans('general.entries.messages.invalid')]);
    }


    /**
    * Delete the entry
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    EntriesController::getCreate()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postDelete($entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {
            $user = Auth::user();

            if (!$entry->checkUserCanEditEntry($user)) {
                return redirect()->route('browse')->with('error', trans('general.entries.messages.delete_not_allowed'));
            }
            else {
                if ($entry->delete()) {
                    $entry->exchangeTypes()->detach();
                    return redirect()->route('browse')->with('success', trans('general.entries.messages.delete_success'));
                }
                return redirect()->route('entry.view', $entry->id)->with('error', trans('general.entries.messages.delete_failed'));
            }

        }
        return redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
    }


    /**
    * Validates and stores an image uploaded via AJAX
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return String JSON
    */
    public function ajaxUpload()
    {
        $entry = null;
        if( Input::has('entry_id')) {
            $entryID = Input::get('entry_id');
            $entry = \App\Entry::find($entryID);
        }

        if (Input::hasFile('image')) {
            $uploaded = false;
            $rotation=null;

            if(!empty(Input::get('rotation'))) {
                $rotation = Input::get('rotation');
            }
            
            if ($entry) {
                $uploaded = $entry->uploadImage(Auth::user(), Input::file('image'), 'entries', $rotation);
            } 
            else {
                $uploaded = \App\Entry::uploadTmpImage(Auth::user(), Input::file('image'), 'entries', Input::get('upload_key'), $rotation);
            }
            if ($uploaded) {
                return response()->json(['success'=>true]);
            } 
            else {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.upload_fail')]);
            }
        } 
        else {
            return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.no_image')]);
        }
    }


    /**
    * Returns the JSON response to populate the datatable for browsing
    * entries in a community.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return String JSON
    */
    public function getEntriesDataView(Request $request, $user_id = null)
    {
        if ($user_id) {
            $entries = $request->whitelabel_group->entries()->with('author','exchangeTypes')->where('created_by', $user_id);
        }
        else {
            $entries = $request->whitelabel_group->entries()->with('author','exchangeTypes')->NotCompleted();
        }

        if (Input::has('search')) {
            $entries->TextSearch(e(Input::get('search')));
        }

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        }
        else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        }
        else {
            $limit = 50;
        }

        $allowed_columns =
        [
            'title',
            'location',
            'tags',
            'created_at'
        ];

        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'entries.created_at';
        $order = Input::get('order') == 'desc' ? 'desc' : 'asc';

        $count = $entries->count();
        $entries = $entries->orderBy($sort, $order);
        $entries = $entries->skip($offset)->take($limit)->get();

        $rows = array();

        if (Auth::check()) {
            $user = Auth::user();
        }
        else {
            $user = null;
        }

        $exchangeTypes=array();
        foreach ($entries as $entry) {
            if (($user) && ($entry->deleted_at=='') && ($entry->checkUserCanEditEntry($user))) {
                $actions = '<button class="btn btn-warning btn-sm"><a href="'.route('entry.edit.form', $entry->id).'"><i class="fa fa-pencil" style="color:white;"></i></a> <button class="btn btn-danger btn-sm" id="delete_entry_'.$entry->id.'"><i class="fa fa-trash"></i></button>';
            }
            else {
                $actions = '';
            }
            
             // ensure array is empty
            $exchangeTypes=[];
            foreach ($entry->exchangeTypes as $et) {
                $exchangeTypes[] = $et->name;
            }

            $image = \DB::table('media')
                ->where('entry_id', '=', $entry->id)
                ->first();

            if ($image) {
                $imageTag = '<img src="/assets/uploads/entries/'.$entry->id.'/'.$image->filename.'" class="entry_image">';
            }
            else {
                $imageTag = null;
            }


            $rows[] = array(
              'image' => $imageTag,
              'title' => strtoupper($entry->post_type).': <a href="'.route('entry.view', $entry->id).'">'.$entry->title.'</a>',
              'author' => '<img src="'.$entry->author->gravatar().'" class="avatar-sm hidden-xs"><a href="'.route('user.profile', $entry->author->id).'">'.$entry->author->getDisplayName().'</a>',
              'location' => $entry->location,
              'created_at' => $entry->created_at->format('M jS, Y'),
              'actions' => $actions,
              'tags' => $entry->tags,
              'exchangeTypes' => implode(', ',$exchangeTypes)
            );
        }

        $data = array('total' => $count, 'rows' => $rows);

        return $data;
    }

    /**
    * Mark an entry as completed
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return Redirect
    */
    public function completeEntry($entryID)
    {
        // Needs auth stuff here
        $entry = Entry::find($entryID);
        if ($entry) {
            $entry->completed_at = date("Y-m-d H:i:s");
            $entry->save();
            return redirect()->route('browse')->with('success', trans('general.entries.messages.completed'));
        }
    }
}
