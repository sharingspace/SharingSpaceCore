<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Entry;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the entry.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entry $entry
     * @return mixed
     */
    public function view(User $user, Entry $entry)
    {
        //
    }

    /**
     * Determine whether the user can create entries.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the entry.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entry $entry
     * @return mixed
     */
    public function update(User $user, Entry $entry)
    {
        //
    }

    /**
     * Determine whether the user can delete the entry.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entry $entry
     * @return mixed
     */
    public function delete(User $user, Entry $entry)
    {
        if ($user->getKey() === (int)$entry->created_by) {
            return true;
        }

        return false;
    }
}
