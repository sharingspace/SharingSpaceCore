<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use App\Entry;


class EntriesController extends ApiGuardController
{

  protected $apiMethods = [
      'all' => [
          'keyAuthentication' => false
      ],
      'show' => [
          'keyAuthentication' => false
      ],
  ];


    public function all()
    {
        $entries = Entry::with('author')->get();
        return $this->response->withCollection($entries, new \App\Http\Transformers\EntriesTransformer);
    }

    public function show($id)
    {
        try {

            $entry = Entry::findOrFail($id);
            return $this->response->withItem($entry, new \App\Http\Transformers\EntriesTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();

        }

    }


    public function entrylist($id)
    {
        try {

            $entry = Entry::findOrFail($id);
            return $this->response->withItem($entry, new \App\Http\Transformers\EntriesTransformer);

        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound();

        }
    }

}
