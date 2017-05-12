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
use Auth;
use Theme;
use Validator;
use Input;
use Redirect;
use Helper;
use Log;
use Gate;
use App\Entry;
use Illuminate\Support\Facades\Route;

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
      //log::debug("getEntry: entered >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>".Route::currentRouteName());

      if ($entry = \App\Entry::find($entryID)) {
        if ($request->user()) {
          // user logged in
          if ($request->user()->cannot('view-entry', $request->whitelabel_group)) {
            return redirect()->route('home')->with('error', trans('general.entries.messages.not_allowed'));
          }
        }
        else {
          // user not logged in. Can see entry only if Share is open
          if(!$request->whitelabel_group->isOpen()) {
            return redirect()->route('home')->with('error', trans('general.entries.messages.entry_view_not_allowed'));
          }
        }
            
        $images = \DB::table('media')
          ->where('entry_id', '=', $entryID)
          ->get();

        if ("kiosk_entry" == Route::currentRouteName()) {
          $type = ($entry->post_type == 'want') ? 'wants' : 'has';

          $tagArray =  explode (',', $entry->tags);
          $category = null;
          foreach($tagArray as $tag) {
            $tag = trim($tag);

            if (in_array($tag, Entry::$tagList)) {
              $category = $tag;
            }
          }
          return view('kiosk.entry')->with('entry', $entry)->with('images', $images)->with('natural_type', $type)->with('category', $category);
        }
        else {
          return view('entries.view')->with('entry', $entry)->with('images', $images);
        }
      }
      else {
        return redirect()->route('home')->with('error', trans('general.entries.messages.invalid'));
      }
    }

    public function ajaxGetEntry(Request $request, $entryID)
    {
        //log::debug("ajaxGetEntry: entered >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");

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

            return response()->json(['success'=>true, 'entry_id'=>$entry->id,'title' => html_entity_decode($entry->title, ENT_QUOTES), 'description' => html_entity_decode($entry->description, ENT_QUOTES), 'post_type'=>$entry->post_type, 'qty'=>$entry->qty,'exchange_types' =>$types,'exchange_type_ids' => $typeIds, 'tags' => html_entity_decode($entry->tags, ENT_QUOTES), 'location'=>$entry->location, 'visible'=>$entry->visible, 'image'=>$imageName]);

        }
        else {
            log::error("ajaxGetEntry: invalid entry Id = ".$entryID);
            redirect()->route('home')->with('error', trans('general.entries.messages.invalid'));
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
        //log::debug("getCreate: entered >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");

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
        //log::debug("postAjaxCreate: entered >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");

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

        if (Auth::user()->isSuperAdmin() && !Auth::user()->isMemberOfCommunity($request->whitelabel_group, true)) {
            if (Auth::user()->communities()->sync([$request->whitelabel_group->id])) {
                //LOG::debug("postAjaxCreate: joined superAdmin to share successfully");
            }
            else {
                //LOG::error("postAjaxCreate: failed to joined superAdmin to share successfully");
            }
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
                array_push($typeIds, $et->id);
            }
            $uploaded = true;

            if (Input::hasFile('file')) {
                Log::debug("postAjaxCreate: We have a file - and, weirdly, kinda shouldn't?");
                $rotation=null;
                if (!empty(Input::get('rotation'))) {
                    $rotation = Input::get('rotation');
                }

                if (!$entry->uploadImage(Auth::user(), Input::file('file'), 'entries', $rotation)) {
                    return response()->json(['success'=>false, 'error'=>trans('general.entries.messages.rotation_failed')]);
                }
            } else {
                //Log::debug("postAjaxCreate: moving tmp image, entry_id = ".$entry->id.", upload_key = ".$upload_key);

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
        //log::debug("getEdit: entered >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");

        // This should be pulled into a helper or macro
        $post_types = array('want'=>'I want', 'have'=>'I have');

        if ($entry = \App\Entry::find($entryID)) {

            $user = Auth::user();

            if ($request->user()->cannot('update-entry', $entry)) {
                return redirect()->route('home')->with('error', trans('general.entries.messages.not_allowed'));
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

            $selected_exchanges=[];
            foreach ($entry->exchangeTypes as $et) {
                $selected_exchanges[$et->id] = $et->name;
            }

            return view('entries.edit')->with('entry', $entry)
                                        ->with('post_types', $post_types)
                                        ->with('selected_exchanges', $selected_exchanges)
                                        ->with('image', $imageName);
        }
        else {
            log::error("getEdit: invalid entry Id = ".$entryID);
            return redirect()->route('home')->with('error', trans('general.entries.messages.invalid'));
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

        log::error("postAjaxEdit: invalid entry Id = ".$entryID);
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
        //log::debug("postEdit: entered >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");

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

            if (Input::has('completed') && Input::get('completed')) {
              $entry->completed_at = date("Y-m-d H:i:s");
            }
            else {
              $entry->completed_at = null;
            }

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
            }
            else if (Input::get('rotation')) {
              if(!\App\Entry::rotateImage($user->id, $entry->id, 'entries', (int)Input::get('rotation'))) {
                return redirect()->route('home')->with('error', trans('general.entries.messages.save_failed'));
              }
            }

            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            return redirect()->route('entry.view', $entry->id)->with('success', trans('general.entries.messages.save_edits'));
        }

        log::error("postEdit: invalid entry Id = ".$entryID);
        return redirect()->route('home')->with('error', trans('general.entries.messages.invalid'));
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
        log::error("postAjaxDelete: invalid entry Id = ".$entryID);
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
                return redirect()->route('home')->with('error', trans('general.entries.messages.delete_not_allowed'));
            }
            else {
                if ($entry->delete()) {
                    $entry->exchangeTypes()->detach();
                    return redirect()->route('home')->with('success', trans('general.entries.messages.delete_success'));
                }
                return redirect()->route('entry.view', $entry->id)->with('error', trans('general.entries.messages.delete_failed'));
            }

        }

        log::error("postDelete: invalid entry Id = ".$entryID);
        return redirect()->route('home')->with('error', trans('general.entries.messages.invalid'));
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
            if (Auth::user() && (Auth::user()->id == $user_id)) {
                // allow user to their hidden entries
                $entries = $request->whitelabel_group->entries()->with('author','exchangeTypes','media')->where('created_by', $user_id);
            }
            else {
                $entries = $request->whitelabel_group->entries()->with('author','exchangeTypes','media')->where('created_by', $user_id)->where('visible', 1);
            }
        }
        else {
            $entries = $request->whitelabel_group->entries()->with('author','exchangeTypes','media')->where('visible', 1)->NotCompleted();
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

        foreach ($entries as $entry) {
            if (($user) && ($entry->deleted_at=='') && ($entry->checkUserCanEditEntry($user))) {
                $actions = '<a href="'.route('entry.edit.form', $entry->id).'">
                                <button class="btn btn-light-colored btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </a>
                            <button class="btn btn-dark-colored btn-sm" id="delete_entry_'.$entry->id.'">
                                <i class="fa fa-trash"></i>
                            </button>';
            }
            else {
                $actions = '';
            }

            if ($entry->completed_at) {
                $completed ="<i class='fa fa-lg fa-check completed' data-toggle='tooltip' data-placement='top' title='Completed'></i>";
            }
            else {
                $completed = null;
            }

             // ensure array is empty
            $exchangeTypes=[];
            foreach ($entry->exchangeTypes as $et) {
                $exchangeTypes[] = $et->name;
            }

            $image = $entry->media->first();

            if ($image) {
                $imageTag = '<a href="'.route('entry.view', $entry->id).'"><img src="/assets/uploads/entries/'.$entry->id.'/'.$image->filename.'" class="entry_image"></a>';
            }
            else {
                $imageTag = '<a href="'.route('entry.view', $entry->id).'" class="'.$entry->post_type.'_square"></a>';
            }

            if ($entry->author->isMemberOfCommunity($request->whitelabel_group)) {
                $rows[] = array(
                  'image' => $imageTag,
                  'post_type' => strtoupper($entry->post_type).$completed,
                  'title' => '<a href="'.route('entry.view', $entry->id).'">'.$entry->title.'</a>',
                  'author' => '<img src="'.$entry->author->gravatar_img().'" class="avatar-sm hidden-xs">'
                              .'<a href="'.route('user.profile', $entry->author->id).'">'
                              .$entry->author->getDisplayName().'</a>'
                              .(($entry->author->getCustomLabelInCommunity($request->whitelabel_group)) ?
                                    ' <span class="label label-primary">'
                                    .$entry->author->getCustomLabelInCommunity($request->whitelabel_group)
                                    .'</span>' : ''),

                  'location' => $entry->location,
                  'created_at' => $entry->created_at->format('M jS, Y'),
                  'actions' => $actions,
                  'tags' => $entry->tags,
                  'exchangeTypes' => implode(', ',$exchangeTypes)
                );
            }
            else {
                // we have an entry who doesn't belong to this community - something went very wrong
                $rows[] = array('image' => '-', 'post_type' => '-', 'title' => '-', 'author' => '-',
                                 'location' => '-', 'created_at' => '-', 'actions' => '-', 'tags' => '-', 'exchangeTypes' => '-');
            }
        }

        $data = array('total' => $count, 'rows' => $rows);

        return $data;
    }


    /**
    * Returns the a list of categories based on tag field,
    * this is only temopary code and needs to re-written.
    *
    * @author [D. Linnard] [<david@linnard.com>]
    * @since  [v1.0]
    * @return list of categories
    */
    public function getKioskEntries(Request $request, $tagName = null)
    {
      $entryList = array();
      $entries = array();
      $added = array();

      //$tagList = ["Art", "Ecology", "Skills", "Learning Opportunities", 
      //  "Community Resources", "Meet a Resident", "Free", "Upcycle Projects", "Dreams"];

      if ($tagName) {
        $entries = Entry::TagSearch($tagName)->get();
      }
      else {
        $entries = $request->whitelabel_group->entries()->where('visible', 1)->whereNotNull('tags')->where('tags', '!=', '')->NotCompleted()->get();
        $entries = $entries->unique('tags');
      }

      $count = $entries->count();
      $i = 0;

      foreach ($entries as $entry) {
        // create an array from our comma separated string
        $tagArray =  explode (',', $entry->tags);
        foreach($tagArray as $tag) {
          $tag = trim($tag);

          if (in_array($tag, Entry::$tagList) && ($tagName || !in_array($tag, $added))) {
            $added[] = $tag;

            $tagparts =  explode (' ', strtolower($tag));
            $tagImage = '/assets/img/kiosk/'.implode('_', $tagparts).'.jpg';

            if ($entry->author->isMemberOfCommunity($request->whitelabel_group)) {
              if ($tagName) {
                $entryList[] = array(
                  'image' => $tagImage,
                  'tag' => $tag,
                  'entryId' => $entry->id,
                  'name' => $entry->author->getDisplayName(),
                  'type' => ($entry->post_type == 'want') ? 'wants' : 'has',
                  'title' => $entry->title,
                  'qty' => $entry->qty,
                  'color' => $entry->post_type,
                );
              }
              else {
                $entryList[] = array(
                  'image' => $tagImage,
                  'tag' => $tag,
                  'entryId' => $entry->id,
                  'tint_shade' => 't'.$i
                );
              }
            }
            else {
                // we have an entry who doesn't belong to this community - something went very wrong
                $entryList[] = array('image' => '-', 'tag' => '-', 'tint_shade' => 't0');
            }

            if ($i++ > 9) {
              $i = 0;
            }
          }
        }
      }

      // sort them by tag name
      usort($entryList, function($a, $b) {
        return strnatcmp($a['tag'], $b['tag']);
      });

      if ($tagName) {
        return view('kiosk.category_entries', ['entryList' => $entryList, 'tag' => $tagName]);
      }
      else {
        $entryList =  $input = array_map("unserialize", array_unique(array_map("serialize", $entryList)));
        return view('kiosk.categories')->with('entryList', $entryList);
      }
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
            return redirect()->route('home')->with('success', trans('general.entries.messages.completed'));
        }
    }
}
