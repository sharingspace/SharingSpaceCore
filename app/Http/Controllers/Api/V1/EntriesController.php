<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Community;
use \App\Http\Transformers\EntriesTransformer;

class EntriesController extends Controller
{



    /**
     * Display all entries within the current group
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return String JSON
     */
    public function all(Request $request)
    {
        $jwt = (new \Lcobucci\JWT\Parser())->parse($request->bearerToken());
        $community_id = $jwt->getClaim('community')->id;
        
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


    /**
     * Return details about a specific entry.
     *
     * We have to paginate(1) here, since the transformer is expecting an instance of the paginator.
     * There may be a more elegant way to do this.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @param $id The ID of the entry
     * @return String JSON
     */
    public function show(Request $request,$entry_id)
    {
        $jwt = (new \Lcobucci\JWT\Parser())->parse($request->bearerToken());
        $community_id = $jwt->getClaim('community')->id;
    
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
}