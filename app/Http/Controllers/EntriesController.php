<?php
/**
 * This controller handles all actions related to Entries for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 * @package    AnyShare
 * @version    v1.0
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
    * @since [v1.0]
    * @return View
    */
    public function getEntry(Request $request, $entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {

            if ($request->user()->cannot('view-entry', $entry)) {
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


    /**
    * Returns a view that makes a form to create a new entry
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see EntriesControllers::postCreate()
    * @since [v1.0]
    * @return View
    */
    public function getCreate(Request $request)
    {
        $request->session()->put('upload_key', str_random(15));
        return view('entries.create');
    }


    /**
    * Validates and stores the new entry data via AJAX request.
    *
    * @author [David Linnard] [<dslinnard@gmail.com>]
    * @since [v1.0]
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

        if (Input::get('location')) {
            $entry->location = e(Input::get('location'));
            $latlong = Helper::latlong(Input::get('location'));
        }

        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
            $entry->latitude         = $latlong['lat'];
            $entry->longitude     = $latlong['lng'];
        }

        if ($entry->isInvalid()) {
            return response()->json(['success'=>false, 'error'=>$entry->getErrors()]);
        }


        if ($request->whitelabel_group->entries()->save($entry)) {
            Log::debug("Saving whitelabel group, id: ".$entry->id." upload_key: ".$upload_key);
            $entry->exchangeTypes()->sync(Input::get('exchange_types'));
            $types=[];

            foreach($entry->exchangeTypes as $et) {
                array_push($types, $et->name);
            }
            $uploaded = true;

            if (Input::hasFile('file')) {
                Log::debug("We have a file - and, weirdly, kinda shouldn't?");
                $entry->uploadImage(Auth::user(), Input::file('file'), 'entries');
            }
            else {
                Log::debug("no file was detected, we should just be moving files from temp-to-perm");
                $uploaded = \App\Entry::moveImagesForNewTile(Auth::user(), $entry->id, $upload_key);
            }

            if($uploaded) {
                return response()->json(['success'=>true, 'save'=>true, 'entry_id'=>$entry->id, 'title'=>$entry->title, 'description'=>$entry->description, 'post_type'=>$entry->post_type,'qty'=>$entry->qty,'exchange_types' =>$types, 'tags' => $entry->tags]);
            }
            else {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.upload_failed')]);
            }
        }

        return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);

    }



    /**
    * Validates and stores the new entry.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see EntriesController::getCreate()
    * @since [v1.0]
    * @return Redirect
    */
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

                    if (\App\Entry::moveImagesForNewTile(Auth::user(), $request->session()->get('upload_key'))) {
                        echo response()->json(['success'=>true, 'tile_id'=>$entry->id, 'title'=>$entry->title, 'post_type'=>$entry->post_type, 'exchange_types'=>Input::get('exchange_types')]);
                    } else {
                        return response()->json(['success'=>false]);
                    }
                    return response()->json(['success'=>false]);
                }

            }

            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            return response()->json(['success'=>true, 'tile_id'=>$entry->id, 'title'=>$entry->title, 'post_type'=>$entry->post_type, 'exchange_types'=>Input::get('exchange_types')]);

        }
        return redirect()->back()->with('error', trans('general.entries.messages.save_failed'));

    }

    /**
    * Returns a form view to edit an entry
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see EntriesController::postEdit()
    * @since [v1.0]
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

             return view('entries.edit')->with('entry', $entry)->with('post_types', $post_types);


        } else {
            return redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
        }

    }


    /**
    * Validates and stores the entry edits submitted via AJAX.
    *
    * @author [David Linnard] [<dslinnard@gmail.com>]
    * @since [v1.0]
    * @return String JSON
    */
    public function postAjaxEdit(Request $request, $entryID)
    {

        if ($entry = \App\Entry::find($entryID)) {

            $user = Auth::user();

            if ($request->user()->cannot('update-entry', $entry)) {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.not_allowed')]);
            }

            $entry->title    = e(Input::get('title'));
            $entry->post_type    = e(Input::get('post_type'));
            $entry->description    = e(Input::get('description'));
            $entry->qty    = e(Input::get('qty'));
            $entry->tags    = e(Input::get('tags'));

            if (Input::get('location')) {
                $entry->location = e(Input::get('location'));
                $latlong = Helper::latlong(Input::get('location'));
            }

            if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
                $entry->latitude           = $latlong['lat'];
                $entry->longitude         = $latlong['lng'];
            }

            if (!$entry->save()) {
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.save_failed')]);
            }

            if (Input::hasFile('file')) {
                $entry->uploadImage(Auth::user(), Input::file('file'), 'entries');
            }

            $types=[]; //FIXME this is broken. Sorry. I don't know why it doesn't work.
            if ($request->whitelabel_group->entries()->save($entry)) {
                $entry->exchangeTypes()->sync(Input::get('exchange_types'));

                foreach($entry->exchangeTypes as $et) {
                    array_push($types, $et->name);
                }
            }

            return response()->json(['success'=>true, 'save'=>false, 'entry_id'=>$entry->id,'title'=>$entry->title,'post_type'=>$entry->post_type, 'qty'=>$entry->qty,'exchange_types' =>$types]);

        }

        return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.invalid')]);

    }



    /**
    * Validates and stores the entry edits.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see EntriesController::getEdit()
    * @since [v1.0]
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
                $entry->uploadImage(Auth::user(), Input::file('file'), 'entries');
            }
             $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            return redirect()->route('entry.view', $entry->id)->with('success', trans('general.entries.messages.save_edits'));
        }

        return redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
    }


    /**
    * Deletes an entry via AJAX request
    *
    * @todo Consolidate this and the non-ajax delete.
    * @author [David Linnard] [<dslinnard@gmail.com>]
    * @since [v1.0]
    * @return String JSON
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

                return redirect()->route('entry.view', $entry->id)->with('error', trans('general.entries.messages.delete_failed'));
            }
        }

        return redirect()->route('browse')->with('error', trans('general.entries.messages.invalid'));
    }


    /**
    * Delete the entry
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see EntriesController::getCreate()
    * @since [v1.0]
    * @return Redirect
    */
    public function postDelete($entryID)
    {
        if ($entry = \App\Entry::find($entryID)) {
            $user = Auth::user();

            if (!$entry->checkUserCanEditEntry($user)) {
                return redirect()->route('browse')->with('error', trans('general.entries.messages.delete_not_allowed'));
            } else {
                if ($entry->delete()) {
                    $entry->exchangeTypes()->detach();
                    return redirect()->route('browse')->with('success', trans('general.entries.messages.deleted'));
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
    * @since [v1.0]
    * @return String JSON
    */
    public function ajaxUpload($entryID = null)
    {

        if (Input::hasFile('image')) {
            Log::debug("A file was detected amongst thine inputz!");

            $uploaded = false;
            if ($entryID) {
                $uploaded = $entry->uploadImage(Auth::user(), Input::file('image'), 'entries');
            }
            else {
                 Log::debug("Thee upload key is: ".Input::get('upload_key'));
                $uploaded = \App\Entry::uploadTmpImage(Auth::user(), Input::file('image'), 'entries', Input::get('upload_key'));
                 Log::debug("the uploaded result is: ".$uploaded);
            }
            if($uploaded) {
                return response()->json(['success'=>true, 'image'=>'bingo']);
            }
            else {
                 Log::debug("were not able to upload the file, sorry :(");
                return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.invalid')]);
            }
        }
        else {
            Log::debug("No actual file was given, so this whole thing is shot");
            return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.invalid')]);
        }
    }


    /**
    * Returns the JSON response to populate the datatable for browsing
    * entries in a community.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return String JSON
    */
    public function getEntriesDataView(Request $request, $user_id=null)
    {
        if ($user_id) {
            $entries = $request->whitelabel_group->entries()->with('author')->where('created_by', $user_id);
        }
        else {
            $entries = $request->whitelabel_group->entries()->with('author')->NotCompleted();
        }

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
            if (($user) && ($entry->deleted_at=='') && ($entry->checkUserCanEditEntry($user))) {
                $actions = '<button class="btn btn-warning btn-sm"><a href="'.route('entry.edit.form', $entry->id).'"><i class="fa fa-pencil" style="color:white;"></i></a> <button class="btn btn-danger btn-sm" id="delete_entry_'.$entry->id.'"><i class="fa fa-trash"></i></button>';
            } else {
                $actions = '';
            }

            $rows[] = array(
            'title' => '<a href="'.route('entry.view', $entry->id).'">'.$entry->title.'</a>',
            'post_type' => strtoupper($entry->post_type),
            'author' => '<a href="'.route('user.profile', $entry->author->id).'">'.$entry->author->getDisplayName().'</a>',
            'location' => $entry->location,
            'created_at' => $entry->created_at->format('M jS, Y'),
            'actions' => $actions,
            'tags' => $entry->tags
            );
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;

    }

    /**
    * Mark an entry as completed
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
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
