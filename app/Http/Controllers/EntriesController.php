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

use App\Exceptions\ModelOperationException;
use App\Helpers\Wrld3D\PoiManager;
use App\Jobs\Entry\DeleteEntry;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Input;
use Redirect;
use Helper;
use Log;
use App\Models\Entry;
use Illuminate\Support\Facades\Route;
use App\Helpers\CommunityEntries;
use App\Helpers\Permission;

//use Session;

class EntriesController extends Controller
{
    /**
     * Returns a view that displays entry information
     * This route involves the viewEntry middleware which
     * will check whether it is a valid entry, if it's an Open share
     * and if not open whether they are logged in and a member of Share
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return View
     */

    public function getEntry(Request $request, $entryID)
    {
           
        //log::debug("getEntry: entered >>>>>>>>>>>>>>>>>> ".Route::currentRouteName()."  ".$entryID);
        if ($entry = \App\Models\Entry::find($entryID)) {
            
            if ($request->user()) {
                // user logged in
                if ($request->user()->cannot('view-entry', $request->whitelabel_group)) {
                    return redirect()->route('home')->with('error', trans('general.entries.messages.not_allowed'));
                }
            }
            else {
                // user not logged in. Can see entry only if Share is open
                if (!$request->whitelabel_group->isOpen()) {
                    return redirect()->route('home')->with(
                        'error',
                        trans('general.entries.messages.entry_view_not_allowed')
                    );
                }
            }

            $images = \DB::table('media')
                ->where('entry_id', '=', $entryID)
                ->get();

            if ('_kiosk_entry' == Route::currentRouteName()) {
                $type = ($entry->post_type == 'want') ? 'wants' : 'has';

                $tagArray = explode(',', $entry->tags);
                $category = null;
                foreach ($tagArray as $tag) {
                    $tag = strtolower(trim($tag));

                    if (in_array($tag, Entry::$tagList)) {
                        $category = $tag;
                    }
                }
                return view('kiosk.kiosk_entry')->with('entry', $entry)->with('images', $images)->with(
                    'natural_type',
                    $type
                )->with('category', $category);
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

        if ($entry = \App\Models\Entry::find($entryID)) {
            $imageName = null;

            if ($request->user()->cannot('view-entry', $request->whitelabel_group)) {
                return response()->json(['success' => false, 'error' => trans('general.entries.messages.not_allowed')]);
            }

            $types = [];
            $typeIds = [];
            foreach ($entry->exchangeTypes as $et) {
                array_push($types, $et->name);
                array_push($typeIds, $et->id);
            }

            $image = \DB::table('media')
                ->where('entry_id', '=', $entryID)
                ->first();

            if ($image) {
                $imageName = $image->filename;
            }

            return response()->json([
                'success'           => true,
                'entry_id'          => $entry->id,
                'title'             => html_entity_decode($entry->title, ENT_QUOTES),
                'description'       => html_entity_decode($entry->description, ENT_QUOTES),
                'post_type'         => $entry->post_type,
                'qty'               => $entry->qty,
                'exchange_types'    => $types,
                'exchange_type_ids' => $typeIds,
                'tags'              => html_entity_decode($entry->tags, ENT_QUOTES),
                'location'          => $entry->location,
                'visible'           => $entry->visible,
                'image'             => $imageName,
            ]);

        }
        else {
            //log::error("ajaxGetEntry: invalid entry Id = " . $entryID);
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

        $post_types = ['want' => 'I want', 'have' => 'I have'];

        $request->session()->put('upload_key', str_random(15));
        return view('entries.create')
            ->with('post_types', $post_types)
            ->with('entry', new Entry([]));
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

        $entry = new Entry();

        $entry->title = e(Input::get('title'));
        $entry->post_type = e(Input::get('post_type'));
        $entry->description = e(Input::get('description'));
        $entry->created_by = Auth::user()->id;
        $entry->tags = e(strtolower(Input::get('tags')));
        $entry->qty = e(Input::get('qty'));
        $upload_key = e(Input::get('upload_key'));
        $entry->visible = e(Input::get('private')) ? 0 : 1;
        $exchange_types = Input::get('exchange_types');

        $validator = Validator::make($request->all(), $entry->getRules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()]);
        }

        if (Auth::user()->isSuperAdmin() && !Auth::user()->isMemberOfCommunity($request->whitelabel_group, true)) {
            if (Auth::user()->communities()->sync([$request->whitelabel_group->id])) {
                //log::debug("postAjaxCreate: joined superAdmin to share successfully");
            }
            else {
                //log::error("postAjaxCreate: failed to joined superAdmin to share successfully");
            }
        }

        if (empty($exchange_types)) {
            return response()->json([
                'success' => false,
                'error'   => trans('general.entries.messages.no_exchange_types'),
            ]);
        }

        if (Input::get('location')) {
            $entry->location = e(Input::get('location'));
        }

        //        if (!Input::get('latitude') || !Input::get('longitude')) {
        //            $latlong = Helper::latlong(Input::get('location'));
        //        }

        if (Input::get('latitude') && Input::get('longitude')) {
            $entry->latitude = e(Input::get('latitude'));
            $entry->longitude = e(Input::get('longitude'));
        }

        $entry->wrld3d = [
            'indoor_id'    => e(Input::get('indoors_id')),
            'indoor_floor' => e(Input::get('indoors_floor')),
        ];

        if ($entry = $request->whitelabel_group->entries()->save($entry)) {
            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            $types = $typeIds = [];

            foreach ($entry->exchangeTypes as $et) {
                array_push($types, $et->name);
                array_push($typeIds, $et->id);
            }
            $uploaded = true;

            if (Input::hasFile('file')) {
                //log::debug("postAjaxCreate: We have a file - and, weirdly, kinda shouldn't?");
                $rotation = null;
                if (!empty(Input::get('rotation'))) {
                    $rotation = Input::get('rotation');
                }

                if (!$entry->uploadImage(Auth::user(), Input::file('file'), 'entries', $rotation)) {
                    return response()->json([
                        'success' => false,
                        'error'   => trans('general.entries.messages.rotation_failed'),
                    ]);
                }
            }
            else {
                //log::debug("postAjaxCreate: moving tmp image, entry_id = ".$entry->id.", upload_key = ".$upload_key);

                $uploaded = Entry::moveImagesForNewTile(Auth::user(), $entry->id, $upload_key);
            }

            // Save the POI in the Wrld3D
            if ($entry->lat && $entry->lng && $request->whitelabel_group->wrld3d && $request->whitelabel_group->wrld3d->get('poiset')) {
                (new PoiManager($request->whitelabel_group))->savePoi($entry);
            }

            if ($uploaded) {
                //log::debug("postAjaxCreate: image uploaded successfully, returning success");
                return response()->json([
                    'success'        => true,
                    'create'         => true,
                    'entry_id'       => $entry->id,
                    'title'          => $entry->title,
                    'description'    => $entry->description,
                    'post_type'      => $entry->post_type,
                    'qty'            => $entry->qty,
                    'exchange_types' => $types,
                    'tags'           => $entry->tags,
                    'typeIds'        => $typeIds,
                ]);
            }
            else {
                return response()->json([
                    'success' => false,
                    'error'   => trans('general.entries.messages.upload_failed'),
                ]);
            }
        }

        return response()->json(['success' => false, 'error' => trans('general.entries.messages.save_failed')]);
    }

    /**
     * Validates and stores the new entry.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    EntriesController::getCreate()
     * @since  [v1.0]
     * @return Redirect
     */

    public function postCreate(Request $request)
    {
               
        $entry = new \App\Models\Entry();
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

                    if (!\App\Models\Entry::moveImagesForNewTile(Auth::user(), $request->session()->get('upload_key'))) {
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
     * @see    EntriesController::postEdit()
     * @since  [v1.0]
     * @return View
     */
    public function getEdit(Request $request, $entryID)
    {

        //log::debug("getEdit: entered >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");

        // This should be pulled into a helper or macro
        $post_types = ['want' => 'I want', 'have' => 'I have'];

        if ($entry = Entry::find($entryID)) {
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

            $selected_exchanges = [];
            foreach ($entry->exchangeTypes as $et) {
                $selected_exchanges[$et->id] = $et->name;
            }

            return view('entries.edit')->with('entry', $entry)
                ->with('post_types', $post_types)
                ->with('selected_exchanges', $selected_exchanges)
                ->with('image', $imageName);
        }
        else {
            //log::error("getEdit: invalid entry Id = " . $entryID);
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
        if ($entry = Entry::find($entryID)) {
            $user = Auth::user();

            if ($request->user()->cannot('update-entry', $entry)) {
                return response()->json(['success' => false, 'error' => trans('general.entries.messages.not_allowed')]);
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
                return response()->json(['success' => false, 'error' => trans('general.entries.messages.save_failed')]);
            }

            if (Input::hasFile('file')) {
                $entry->uploadImage(Auth::user(), Input::file('file'), 'entries', $rotation);
            }
            else {
                if (Input::has('deleteImage')) {
                    Entry::deleteImage($entry->id, $user->id);
                    Entry::deleteImageFromDB($entry->id, $user->id);
                }
                else {
                    if (Input::has('rotation')) {
                        if (!Entry::rotateImage($user->id, $entry->id, 'entries', (int)Input::get('rotation'))) {
                            return response()->json([
                                'success' => false,
                                'error'   => trans('general.entries.messages.save_failed'),
                            ]);
                        }
                    }
                }
            }

            $types = [];
            $typeIds = [];
            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            foreach ($entry->exchangeTypes as $et) {
                array_push($types, $et->name);
                array_push($typeIds, $et->id);
            }

            return response()->json([
                'success'        => true,
                'create'         => false,
                'entry_id'       => $entry->id,
                'title'          => $entry->title,
                'description'    => $entry->description,
                'post_type'      => $entry->post_type,
                'qty'            => $entry->qty,
                'exchange_types' => $types,
                'typeIds'        => $typeIds,
                'tags'           => $entry->tags,
            ]);
        }

        //log::error("postAjaxEdit: invalid entry Id = " . $entryID);
        return response()->json(['success' => false, 'error' => trans('general.entries.messages.invalid')]);
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

        if ($entry = Entry::find($entryID)) {
            $user = Auth::user();

            if ($request->user()->cannot('update-entry', $entry)) {
                abort(403);
            }

            $entry->title = e(Input::get('title'));
            $entry->post_type = e(Input::get('post_type'));
            $entry->description = e(Input::get('description'));
            $entry->qty = e(Input::get('qty'));
            $entry->tags = e(Input::get('tags'));
            $entry->visible = e(Input::get('private')) ? 0 : 1;

            if (Input::has('completed') && Input::get('completed')) {
                $entry->completed_at = date('Y-m-d H:i:s');
            }
            else {
                $entry->completed_at = null;
            }

            if (Input::get('location')) {
                $entry->location = e(Input::get('location'));
            }

            if (Input::get('latitude') && Input::get('longitude')) {
                $entry->latitude = e(Input::get('latitude'));
                $entry->longitude = e(Input::get('longitude'));
            }

            $currentWrld3d = $entry->wrld3d ?: collect([]);

            $entry->wrld3d = $currentWrld3d->merge([
                'indoor_id'    => e(Input::get('indoors_id')),
                'indoor_floor' => e(Input::get('indoors_floor')),
            ]);

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
            else {
                if (Input::get('entry_image_delete')) {
                    Entry::deleteImage($entry->id, $user->id);
                    Entry::deleteImageFromDB($entry->id, $user->id);
                }
                else {
                    if (Input::get('rotation')) {
                        if (!Entry::rotateImage($user->id, $entry->id, 'entries', (int)Input::get('rotation'))) {
                            return redirect()->route('home')->with(
                                'error',
                                trans('general.entries.messages.save_failed')
                            );
                        }
                    }
                }
            }

            // Save the POI in the Wrld3D
            if ($entry->hasGeolocation() && $request->whitelabel_group->hasWrld3dPoiset()) {
                (new PoiManager($request->whitelabel_group))->savePoi($entry);
            }

            // Update exchange types
            $entry->exchangeTypes()->sync(Input::get('exchange_types'));

            return redirect()->route('entry.view', $entry->id)->with(
                'success',
                trans('general.entries.messages.save_edits')
            );
        }

        //log::error("postEdit: invalid entry Id = " . $entryID);
        return redirect()->route('home')->with('error', trans('general.entries.messages.invalid'));
    }

    /**
     * Deletes an entry via AJAX request
     *
     * @todo   Consolidate this and the non-ajax delete.
     * @author [David Linnard] [<dslinnard@gmail.com>]
     * @since  [v1.0]
     * @param $entryID
     * @return String JSON
     */
    public function postAjaxDelete($entryID)
    {
        try {
            $entry = $this->dispatchNow(new DeleteEntry($entryID));
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'success'  => true,
            'entry_id' => $entry->id,
            'message'  => trans('general.entries.messages.delete_success'),
        ]);
    }

    /**
     * Delete the entry
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    EntriesController::getCreate()
     * @since  [v1.0]
     * @param $entryID
     * @return Redirect
     */
    public function postDelete($entryID)
    {
        try {
            $this->dispatchNow(new DeleteEntry($entryID));
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('home')->with('error', $exception->getMessage());
        } catch (AuthorizationException $exception) {
            return redirect()->route('home')->with('error', $exception->getMessage());
        } catch (ModelOperationException $exception) {
            return redirect()->route('entry.view')->with('error', $exception->getMessage());
        }

        return redirect()->route('home')->with('success', trans('general.entries.messages.delete_success'));
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
        //log::debug("ajaxUpload: uploading image");
        $entry = null;
        if (Input::has('entry_id')) {
            $entryID = Input::get('entry_id');
            $entry = Entry::find($entryID);
        }

        if (Input::hasFile('image')) {
            $uploaded = false;
            $rotation = null;

            if (!empty(Input::get('rotation'))) {
                $rotation = Input::get('rotation');
            }

            if ($entry) {
                $uploaded = $entry->uploadImage(Auth::user(), Input::file('image'), 'entries', $rotation);
            }
            else {
                $uploaded = \App\Models\Entry::uploadTmpImage(
                    Auth::user(),
                    Input::file('image'),
                    'entries',
                    Input::get('upload_key'),
                    $rotation
                );
                //log::debug("ajaxUpload: no existing entry, save it as a temp image, filename is ".$uploaded);
            }
            if ($uploaded) {
                return response()->json(['success' => true]);
            }
            else {
                //log::error("ajaxUpload: upload_fail");
                return response()->json(['success' => false, 'error' => trans('general.entries.messages.upload_fail')]);
            }
        }
        else {
            //log::error("ajaxUpload: no image");
            return response()->json(['success' => false, 'error' => trans('general.entries.messages.no_image')]);
        }
    }

    /**
     * Returns the JSON response to populate the datatable for browsing
     * entries in a community.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return array
     */
    public function getEntriesDataView(Request $request, $user_id = null)
    {
        
        $entries = new CommunityEntries($request->whitelabel_group);
        $user = Auth::check() ? Auth::user() : null;

        if ($user_id) {
            $entries->byUserId($user_id);

            if ($user && $user->id == $user_id) {
                // allow user to view their hidden entries
                $entries->visible();
            }
        }
        else {
            $entries->visible()->notCompleted();
        }

        if (Input::has('search')) {
            $entries->textSearch(e(Input::get('search')));
        }

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        }
        else {
            $offset = 0;
        }

        //if (Input::has('limit')) { pagination stuff and we may need it one day - dsl
        //    $limit = e(Input::get('limit'));
        //}
        //else {
        //    $limit = 50;
        //}

        $allowed_columns = [
            'title',
            'location',
            'latitude',
            'longitude',
            'lat',
            'lng',
            'tags',
            'created_at',
        ];

        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'entries.created_at';
        $order = Input::get('order') == 'asc' ? 'asc' : 'desc';

        $entries = $entries->orderBy($sort, $order)->get();
        $count = $entries->count();
        // $entries = $entries->skip($offset)->take($limit)->get(); pagination stuff and we may need it one day - dsl

        $rows = [];

        // Process all entries
        foreach ($entries as $entry) {
            if ($user && $entry->deleted_at == '' && $entry->checkUserCanEditEntry($user)) {
                $actions = '<a href="' . route('entry.edit.form', $entry->id) . '">
                                <button class="btn btn-light-colored btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </a>
                            <button class="btn btn-dark-colored btn-sm" id="delete_entry_' . $entry->id . '">
                                <i class="fa fa-trash"></i>
                            </button>';
            }
            else {
                $actions = '';
            }

            $completed = $entry->completed_at
                ? "<i class='fa fa-lg fa-check completed' data-toggle='tooltip' data-placement='top' title='Completed'></i>"
                : null;

            // ensure array is empty
            $exchangeTypes = $entry->exchangeTypes->map(function ($et) {
                return $et->name;
            })->toArray();

            $image = $entry->media->first();

            if ($image) {
                $pathInfo = pathinfo('/assets/uploads/entries/' . $entry->id . '/' . $image->filename);
                $ext = $pathInfo['extension'];
                $thumb = $pathInfo['filename'] . '_thumb.' . $ext;

                if (is_file(public_path().'/assets/uploads/entries/' . $entry->id . '/' . $thumb)) {
                    $imageName = $thumb;
                }
                else {
                    $imageName = $image->filename;
                }

                $imageTag = '<a href="' . route('entry.view', $entry->id) . '"><img src="/assets/uploads/entries/' . $entry->id . '/' . $imageName . '" class="entry_image"></a>';
                $image_url = '/assets/uploads/entries/' . $entry->id . '/' . $imageName;
                $url = url('/');
                $aspect_ratio = 1;
                $parsed = parse_url($url); // analyse the URL
                if (isset($parsed['scheme']) && strtolower($parsed['scheme']) == 'https') {
                    // If it is https, change it to http
                    $url = 'http://' . substr($url, 8);
                    list($width, $height) = getimagesize($url . $image_url);
                    $aspect_ratio = round($width / (float)$height, 1);
                }
            } 
            else {
                $imageTag = '<a href="' . route(
                    'entry.view',
                        $entry->id
                ) . '" class="' . $entry->post_type . '_square"></a>';
                $image_url = null;
                $aspect_ratio = 0;
            }

            // Process the entry
            if ($entry->author->isMemberOfCommunity($request->whitelabel_group)) {
                if ((!$entry->lat || !$entry->lng) && $entry->location) {
                    $latlong = Helper::latlong($entry->location);

                    $entry->lat = $latlong['lat'];
                    $entry->lng = $latlong['lng'];
                    $entry->save();
                }

                $entryData = [
                    'url'               => route('entry.view', $entry->id),
                    'image'             => $imageTag,
                    'image_url'         => $image_url,
                    'title_link'        => '<a href="' . route('entry.view', $entry->id) . '">' . $entry->title . '</>',
                    'post_type_link'    => '<a href="' . route('entry.view', $entry->id) . '">' . strtoupper($entry->post_type) . $completed . '</>',
                    'post_type'         => strtoupper($entry->post_type) . $completed,
                    'entry_id'          => $entry->id,
                    'title'             => (strlen($entry->title) + strlen($entry->author->getDisplayName()) > 30) ? substr($entry->title, 0, 27) . '&hellip;' : $entry->title,
                    'author_image'      => '<img src="' . $entry->author->gravatar_img() . '" class="avatar-sm hidden-xs">',
                    'location'          => $entry->location,
                    'lat'               => $entry->lat,
                    'lng'               => $entry->lng,
                    'created_at'        => $entry->created_at->format('M jS, Y'),
                    'actions'           => $actions,
                    'tags'              => $entry->tags,
                    'exchangeTypes'     => implode(', ', $exchangeTypes),
                    'display_name'      => $entry->author->getDisplayName(),
                    'natural_post_type' => $entry->natural_post_type,
                    'aspect_ratio'      => $aspect_ratio,
                    'author_name'       => '<a href="' . route('user.profile', $entry->author->id) . '">'
                        . $entry->author->getDisplayName() . '</a>'
                        . (($entry->author->getCustomLabelInCommunity($request->whitelabel_group)) ?
                            ' <span class="label label-primary">'
                            . $entry->author->getCustomLabelInCommunity($request->whitelabel_group)
                            . '</span>' : ''),
                    'wrl3d'             => $entry->wrld3d,
                    //                    'poi'               => $poiManager->getPoi($entry),
                ];

                if ($request->whitelabel_group->hasWrld3dPoiset() && $entry->hasWrldPoi()) {
                    /*
                     * It is recreating the POI info without requesting it from Wrld API.
                     * FIXME: Duplicated code. It's the same stuff as seen in PoiManager->savePoi().
                     */
                    $entryData = array_merge($entryData, [
                        'poi' => [
                            'id'        => $entry->wrld3d->get('poi_id'),
                            'title'     => $entry->title,
                            'subtitle'  => $entry->author->display_name . ' ' . $entry->natural_post_type . ' ' . $entry->title . '.',
                            'lat'       => $entry->lat,
                            'lon'       => $entry->lng,
                            'indoor'    => !is_null($entry->wrld3d->get('indoor_id')),
                            'indoor_id' => !is_null($entry->wrld3d->get('indoor_id')) ? $entry->wrld3d->get('indoor_id') : null,
                            'floor_id'  => !is_null($entry->wrld3d->get('indoor_id')) ? $entry->wrld3d->get('indoor_floor') : null,
                            'user_data' => [
                                'entry_id'          => $entry->getKey(),
                                'url'               => route('entry.view', $entry->getKey()),
                                'natural_post_type' => $entry->natural_post_type,
                                'author_name'       => $entry->author->display_name,
                                'exchange_types'    => $entry->exchangeTypes->pluck('name')->implode(', '),
                                'image_url'         => ($entry->media->count() && $entry->media->first()->filename)
                                    ? $userData['image_url'] = Helper::cdn('uploads/entries/' . $entry->id . '/' . $entry->media->first()->filename)
                                    : null,
                            ],
                        ],
                    ]);
                }

                $rows[] = $entryData;
            }
            else {
                // we have an entry who doesn't belong to this community - something went very wrong
                $rows[] = [
                    'image'          => '-',
                    'image-url'      => '-',
                    'title_link'     => '-',
                    'post_type_link' => '-',
                    'post_type'      => '-',
                    'entry_id'       => $entry->id,
                    'author'         => '-',
                    'location'       => '-',
                    'latitude'       => '-',
                    'longitude'      => '-',
                    'created_at'     => '-',
                    'actions'        => '-',
                    'tags'           => '-',
                    'exchangeTypes'  => '-',
                    'aspect_ratio'   => $aspect_ratio,
                ];
            }
        }

        // After loading the entries, we request Points of Interest that was not created on Anyshare.
        $poiManager = new PoiManager($request->whitelabel_group);

        $allPois = $poiManager->getPoiList(['ignoreEntries' => true])->values();

        // Get default entry layout. Default to grid.
        $entryLayout = $request->whitelabel_group->getLayout() ? $request->whitelabel_group->getLayout() : 'G';

        return [
            'total'    => $count,
            'rows'     => $rows,
            'pois'     => $allPois,
            'viewType' => $entryLayout,
        ];
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
        $entryList = [];
        $entries = [];
        $added = [];

        if ($tagName) {
            $entries = $request->whitelabel_group->entries()->where('tags', 'like', '%' . $tagName . '%')->where('visible', 1)->NotCompleted()->get();
            $tagArray[] = $tagName;
        }
        else {
            $entries = $request->whitelabel_group->entries()->where('visible', 1)->whereNotNull('tags')->where(
                'tags',
                '!=',
                ''
            )->NotCompleted()->get();
            $entries = $entries->unique('tags');
        }

        $i = 0;
        foreach ($entries as $entry) {
            // create an array from our comma separated string
            if (!$tagName) {
                $tagArray = explode(',', $entry->tags);
            }

            foreach ($tagArray as $tag) {
                $tag = strtolower(trim($tag));

                if (in_array($tag, Entry::$tagList) && ($tagName || !in_array($tag, $added))) {
                    $added[] = $tag;

                    $tagparts = explode(' ', strtolower($tag));
                    $tagImage = '/assets/img/kiosk/' . implode('_', $tagparts) . '.jpg';

                    if ($entry->author->isMemberOfCommunity($request->whitelabel_group)) {
                        if ($tagName) {
                            $entryList[] = [
                                'image'   => $tagImage,
                                'tag'     => $tag,
                                'entryId' => $entry->id,
                                'name'    => $entry->author->getDisplayName(),
                                'type'    => ($entry->post_type == 'want') ? 'wants' : 'has',
                                'title'   => $entry->title,
                                'qty'     => $entry->qty,
                                'color'   => $entry->post_type,
                            ];
                        }
                        else {
                            $entryList[] = [
                                'image'      => $tagImage,
                                'tag'        => $tag,
                                'entryId'    => $entry->id,
                                'tint_shade' => 't' . $i,
                            ];
                        }
                    }
                    else {
                        // we have an entry who doesn't belong to this community - something went very wrong
                        $entryList[] = ['image' => '-', 'tag' => '-', 'tint_shade' => 't0'];
                    }

                    if ($i++ > 9) {
                        $i = 0;
                    }
                }
            }

            // sort them by tag name
            usort($entryList, function ($a, $b) {
                return strnatcmp($a['tag'], $b['tag']);
            });
        }

        if ($tagName) {
            return view('kiosk.category_entries', ['entryList' => $entryList, 'tag' => $tagName]);
        } 
        else {
            $entryList = $input = array_map('unserialize', array_unique(array_map('serialize', $entryList)));
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
            $entry->completed_at = date('Y-m-d H:i:s');
            $entry->save();
            return redirect()->route('home')->with('success', trans('general.entries.messages.completed'));
        }
    }
}
