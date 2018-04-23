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
        if ($request->has('per_page')) {
            $per_page = $request->input('per_page');
        } else {
            $per_page = 20;
        }


        try {
            $entries = Community::findOrFail($request->whitelabel_group->id)->entries()->with('author')->notCompleted()->orderBy('created_at','desc')->paginate($per_page);
            return $this->response->withItem($entries, new EntriesTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();

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
    public function show($id)
    {
        try {

            $entry = Entry::findOrFail($id)->paginate(1);
            return $this->response->withItem($entry, new EntriesTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();

        }

    }




}
