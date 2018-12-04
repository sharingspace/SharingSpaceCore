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
            return response()->json($trnsform);     
        } catch (Exception $e) {
                
        }
    }

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
            return response()->json(['success' => false, 'errors' => $validator->messages()]);
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
                    return response()->json([
                        'success' => false,
                        'error'   => trans('general.entries.messages.rotation_failed'),
                    ]);
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

        //log::error("postAjaxEdit: invalid entry Id = " . $entry_id);
        return response()->json(['success' => false, 'error' => trans('general.entries.messages.invalid')]);
    }

    public function deleteEntry() {

    }

    public function getSettings() {

    }


}