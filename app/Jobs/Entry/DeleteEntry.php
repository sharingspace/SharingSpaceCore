<?php

namespace App\Jobs\Entry;

use App\Exceptions\ModelOperationException;
use App\Helpers\Wrld3D\PoiManager;
use App\Models\Entry;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DeleteEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $entryID;

    /**
     * Create a new job instance.
     *
     * @param $entryID
     */
    public function __construct($entryID)
    {
        $this->entryID = $entryID;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     * @throws ModelOperationException
     */
    public function handle()
    {

        if (!$entry = Entry::find($this->entryID)) {
            log::error("postDelete: invalid entry Id = " . $this->entryID);
            throw new ModelNotFoundException(trans('general.entries.messages.invalid'));
        }
        
        // First we check if user can edit the entry.
        // If users can't do it, we throw an error.

        if (!$entry->created_by == Auth::user()->id) {
            
            throw new AuthorizationException(trans('general.entries.messages.delete_not_allowed'));
        }

        // Try to delete the entry.
        if (!$entry->delete()) {
            throw new ModelOperationException(trans('general.entries.messages.delete_failed'));
        }

        $entry->exchangeTypes()->detach();

        // Remove Wrld3D POI
        $community = $entry->communities()->first();

        if ($community->wrld3d && $community->wrld3d->get('api_key') && $entry->wrld3d && $entry->wrld3d->get('poi_id')) {
            (new PoiManager($community))->deletePoi($entry->wrld3d->get('poi_id'));
        }

        return $entry;
    }
}
