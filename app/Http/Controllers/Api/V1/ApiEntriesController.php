<?php 
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use Input;
use Validator;
use Helper;
use App\Models\User;
use App\Models\Community;
use App\Helpers\Wrld3D\PoiManager;
use \App\Http\Transformers\EntriesTransformer;
use \App\Http\Transformers\GlobalTransformer;
use App\Jobs\Entry\DeleteEntry;

class ApiEntriesController extends Controller
{


    /*-------------------------------------------------------------------  
     * Old Apis (We will delete later)
     ------------------------------------------------------------------*/
    
    public function all(Request $request){
        $jwt = (new \Lcobucci\JWT\Parser())->parse($request->bearerToken());

        $community_id = $jwt->getClaim('community')->community_id;
        
        if ($request->has('per_page')) {
            $per_page = $request->input('per_page');
        } else {
            $per_page = 20;
        }


        try {
            $entries = Community::findOrFail($community_id)->entries()->with('author')->notCompleted()->orderBy('created_at','desc')->paginate($per_page);

            $trnsform = GlobalTransformer::transform_entries($entries);
            return Helper::sendResponse(true, '', $trnsform); 
        } catch (Exception $e) {
                
        }
    }
     /*
      * Create entry for single sharing space
      */
    public function create(Request $request, $community_id){
        $community = Helper::getCommunity($community_id);
        $user = auth('api')->user();
        $entry = new Entry();

        $entry->title = e(Input::get('title'));
        $entry->post_type = e(Input::get('post_type'));
        $entry->description = e(Input::get('description'));
        $entry->created_by = $user->id;
        $entry->tags = e(strtolower(Input::get('tags')));
        $entry->qty = e(Input::get('qty'));
        $upload_key = e(Input::get('upload_key'));
        $entry->visible = e(Input::get('private')) ? 0 : 1;
        $exchange_types = Input::get('exchange_types');

        $validator = Validator::make($request->all(), $entry->getRules());
        if ($validator->fails()) {
            return Helper::sendResponse(false, $validator->messages()); 
        }

        if ($user->isSuperAdmin() && !$user->isMemberOfCommunity($request->whitelabel_group, true)) {
            if ($user->communities()->sync([$request->whitelabel_group->id])) {
                //log::debug("postAjaxCreate: joined superAdmin to share successfully");
            }
            else {
                //log::error("postAjaxCreate: failed to joined superAdmin to share successfully");
            }
        }

        if (empty($exchange_types)) {
            return Helper::sendResponse(false, trans('general.entries.messages.no_exchange_types'));
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

        $community = Community::findOrFail($community_id);
        if ($entry = $community->entries()->save($entry)) {
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

                if (!$entry->uploadImage($user, Input::file('file'), 'entries', $rotation)) {
                    return Helper::sendResponse(false, trans('general.entries.messages.rotation_failed')); 
                }
            }
            else {
                //log::debug("postAjaxCreate: moving tmp image, entry_id = ".$entry->id.", upload_key = ".$upload_key);

                $uploaded = Entry::moveImagesForNewTile($user, $entry->id, $upload_key);
            }

            // Save the POI in the Wrld3D
            if ($entry->lat && $entry->lng && $request->whitelabel_group->wrld3d && $request->whitelabel_group->wrld3d->get('poiset')) {
                (new PoiManager($request->whitelabel_group))->savePoi($entry);
            }

            if ($uploaded) {
                //log::debug("postAjaxCreate: image uploaded successfully, returning success");
                 $data = [
                    // 'success'        => true,
                    // 'create'         => true,
                    'entry_id'       => $entry->id,
                    'title'          => $entry->title,
                    'description'    => $entry->description,
                    'post_type'      => $entry->post_type,
                    'qty'            => $entry->qty,
                    'exchange_types' => $types,
                    'tags'           => $entry->tags,
                    'typeIds'        => $typeIds,
                ];
                return Helper::sendResponse(true, 'Created successfully', $data); 

            }
            else {
                return Helper::sendResponse(false, trans('general.entries.messages.upload_failed')); 
            }
        }
        return Helper::sendResponse(false, trans('general.entries.messages.save_failed'));
    }

    /*
     * Get all Exechange types of single sharing space
     */
    public function getExchangeTypes(Request $request, $community_id) {
        $community = Helper::getCommunity($community_id);
        $trnsform = GlobalTransformer::transform_allexchnge_types($community->exchangeTypes);

        return Helper::sendResponse(true, '', $trnsform);
    }

    /*-------------------------------------------------------------------  
     * NEW Apis STARTING POINT
     ------------------------------------------------------------------*/

     /*
      * Get all entries of single sharing space
      */

    public function getEntries(Request $request, $community_id) {

        $community = Helper::getCommunity($community_id);
        
        if ($request->has('per_page')) {
            $per_page = $request->input('per_page');
        } else {
            $per_page = 20;
        }

        $entries = $community->entries()->with('author')->notCompleted()->orderBy('created_at','desc')->paginate($per_page);

        $trnsform = GlobalTransformer::transform_entries($entries);
        
        return Helper::sendResponse(true, '', $trnsform);   
    }

    /*
     * Get single entry from the requested community
     */
    public function getSingleEntry(Request $request, $community_id, $entry_id) {

        $community = Helper::getCommunity($community_id);
    
        $entry = $community
                    ->entries()
                    ->where('entry_id', $entry_id)
                    ->with('author')->notCompleted()
                    ->orderBy('created_at','desc')
                    ->paginate(1);
                   
        $transform = GlobalTransformer::transform_entries($entry);

        return Helper::sendResponse(true, '', $transform);    
    }

    public function updateEntry(Request $request, $community_id) {
        $community = Helper::getCommunity($community_id);
        $entry_id = $request->id;

        if ($entry = Entry::findorfail($entry_id)) {
            $user = auth('api')->user();

            if ($user->cannot('update-entry', [$entry,$community])) {
                return Helper::sendResponse(false, trans('general.entries.messages.not_allowed'));
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
                return Helper::sendResponse(false, trans('general.entries.messages.save_failed'));
            }

            if (Input::hasFile('file')) {
                $entry->uploadImage(auth('api')->user(), Input::file('file'), 'entries', $rotation);
            }
            else {
                if (Input::has('deleteImage')) {
                    Entry::deleteImage($entry->id, $user->id);
                    Entry::deleteImageFromDB($entry->id, $user->id);
                }
                else {
                    if (Input::has('rotation')) {
                        if (!Entry::rotateImage($user->id, $entry->id, 'entries', (int)Input::get('rotation'))) {
                            return Helper::sendResponse(false, trans('general.entries.messages.save_failed'));
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

            $data = [
                // 'success'        => true,
                // 'create'         => false,
                'entry_id'       => $entry->id,
                'title'          => $entry->title,
                'description'    => $entry->description,
                'post_type'      => $entry->post_type,
                'qty'            => $entry->qty,
                'exchange_types' => $types,
                'typeIds'        => $typeIds,
                'tags'           => $entry->tags,
            ];
            return Helper::sendResponse(true, "Updated successfully", $data);

        }

        return Helper::sendResponse(false, trans('general.entries.messages.invalid'));
    }

    public function deleteEntry(Request $request, $community_id, $entryID) {
        // if(!\Permission::checkPermission('delete-any-entry-permission', $request->whitelabel_group)) {
        //     return view('errors.401');       
        // }
        $community = Helper::getCommunity($community_id);

        if (!$entry = Entry::find($entryID)) {
            return Helper::sendResponse(false, trans('general.entries.messages.invalid'));  
        }
        
        // First we check if user can edit the entry.
        // If users can't do it, we throw an error.

        if (!$entry->created_by == auth('api')->user()->id) {
            return Helper::sendResponse(false, trans('general.entries.messages.delete_not_allowed'));  
        }

        // Try to delete the entry.
        if (!$entry->delete()) {
            return Helper::sendResponse(false, trans('general.entries.messages.delete_failed'));  
        }

        $entry->exchangeTypes()->detach();

        // Remove Wrld3D POI
        $community = $entry->communities()->first();

        if ($community->wrld3d && $community->wrld3d->get('api_key') && $entry->wrld3d && $entry->wrld3d->get('poi_id')) {
            (new PoiManager($community))->deletePoi($entry->wrld3d->get('poi_id'));
        }
        return Helper::sendResponse(true, trans('general.entries.messages.delete_success'));            
    }

    public function getSettings() {

    }


}