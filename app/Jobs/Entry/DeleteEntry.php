<?php

namespace App\Jobs\Entry;

use App\Models\Entry;
use Illuminate\Bus\Queueable;
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
     */
    public function handle()
    {
        if (!$entry = Entry::find($this->entryID)) {
            log::error("postDelete: invalid entry Id = " . $this->entryID);
            return [false, trans('general.entries.messages.invalid')];
        }

        // First we check if user can edit the entry.
        // If users can't do it, we throw an error.
        if (!Auth::user()->can('delete', $entry)) {
            return [false, 'home', trans('general.entries.messages.delete_not_allowed')];
        }

        // Try to delete the entry.
        if (!$entry->delete()) {
            return [false, 'entry.view', trans('general.entries.messages.delete_failed')];
        }

        $entry->exchangeTypes()->detach();
        return [true, 'home', trans('general.entries.messages.delete_success')];
    }
}
