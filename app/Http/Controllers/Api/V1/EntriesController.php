<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use Input;
use Validator;
use App\Models\User;
use App\Models\Community;
use App\Helpers\Wrld3D\PoiManager;
use \App\Http\Transformers\EntriesTransformer;

class EntriesController extends Controller
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

                $trnsform = new EntriesTransformer;
            return response()->json($trnsform->transform($entries));     
        } catch (Exception $e) {
                
        }
    }

    public function show(Request $request,$entry_id){
        $jwt = (new \Lcobucci\JWT\Parser())->parse($request->bearerToken());
        
        $community_id = $jwt->getClaim('community')->community_id;
    
        try {

            $entry = Community::findOrFail($community_id)
                        
                        ->entries()
                        ->where('entry_id', $entry_id)
                        ->with('author')->notCompleted()
                        ->orderBy('created_at','desc')
                        ->paginate(1);
                       
            $trnsform = new EntriesTransformer;

            return response()->json($trnsform->transform($entry));     
        } catch (Exception $e) {
                
        }

    }

    public function create(Request $request){
        $jwt = (new \Lcobucci\JWT\Parser())->parse($request->bearerToken());
        $community_id = $jwt->getClaim('community')->community_id;
        $user_id = $jwt->getClaim('community')->user_id;

        $user = User::findOrFail($user_id);
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

        $community = getCommunity($community_id);
        
        if ($request->has('per_page')) {
            $per_page = $request->input('per_page');
        } else {
            $per_page = 20;
        }

        $entries = $community->entries()->with('author')->notCompleted()->orderBy('created_at','desc')->paginate($per_page);

            $trnsform = new EntriesTransformer;
        return $this->sendResponse(true, '', $trnsform->transform($entries));   
    }

    /*
     * Get single entry from the requested community
     */
    public function getSingleEntry(Request $request, $community_id, $entry_id) {

        $community = getCommunity($community_id);
    
        $entry = $community
                    ->entries()
                    ->where('entry_id', $entry_id)
                    ->with('author')->notCompleted()
                    ->orderBy('created_at','desc')
                    ->paginate(1);
                   
        $trnsform = new EntriesTransformer;
        return $this->sendResponse(true, '', $trnsform->transform($entry));    
    }

    /*
     * Store an entry
     */

    public function storeEntry(Request $request, $community_id) {

        $user = auth('api')->user();
        $community = getCommunity($community_id);

        $user = User::findOrFail($user_id);
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

    public function updateEntry() {

    }

    public function deleteEntry() {

    }

    public function getSettings() {

    }


}