<?php

namespace App\Providers;

use App\Models\Entry;
use App\Policies\EntryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.         

     *
     * @var array
     */
    protected $policies = [
        'App\Model\Entry'  => 'App\Policies\EntryPolicy'
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);


        // --------------------------------
        // BEFORE ANYTHING ELSE
        // --------------------------------
        // If this condition is true, ANYTHING else below will be asssumed
        // to be true. This can cause weird blade behavior, so if something
        // happens where you don't understand why something is returning true
        // that shouldn't be true, check that the user in question
        // isn't a superadmin
        // --------------------------------
        // If the user is a super admin, let them through no matter what
        $gate->before(function ($user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // Check if the user can see the community entries
        $gate->define('admin', function ($user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // --------------------------------
        // COMMUNTIY GATES
        // --------------------------------

        // Check if the user can see the community entries
        $gate->define('view-browse', function ($user, $community) {
            //log::debug("view-browse ************** view-browse entered user id = ".$user->id.',   community id = '.$community->id.$community->name);

            if ($user->canSeeCommunity($community) || $community->group_type != 'S') {
                //log::debug("view-browse ************** can view view-browse");
                return true;
            }
        });

        // Check if the user can see the community about page
        $gate->define('view-about', function ($user, $community) {
            // any one can see the about for an open share, even if not logged in
            if ($community->group_type != 'S') {
                return true;
            }

            if (isset($user)) {
                // user is logged in, is this an open Share or are they a member or superAdmin ?
                if ($user->isMemberOfCommunity($community) || $user->isSuperAdmin()) {
                    return true;
                }
            }
        });

        // Check if the user can see the community members page
        $gate->define('view-members', function ($user, $community) {
            //log::debug("view-members ************** view-members entered user id = ".$user->id.',   community id = '.$community->id.$community->name);

            if ($community->group_type != 'S') {
                //log::debug("view-browse ************** can view view-members");
                return true;
            }
        });

        // Check if the user can join a community
        // (they are not already a member)
        $gate->define('join-community', function ($user, $community) {
            if (!$user->isMemberOfCommunity($community)) {
                return true;
            }
        });

        // Check if the user can update the community settings
        // (they are an admin)
        $gate->define('update-community', function ($user, $community) {
            if ($user->isAdminOfCommunity($community)) {
                return true;
            }
        });


        // --------------------------------
        // ENTRY GATES
        // --------------------------------

        // Check the user is a member of the community and therefore post
        // an entry
        $gate->define('post-entry', function ($user, $community) {
            if ($user->isMemberOfCommunity($community)) {
                return true;
            }
        });

        // Check that the user can view an entry
        $gate->define('view-entry', function ($user, $community) {
            if (($community->group_type == 'O') || ($user->isMemberOfCommunity($community))) {
                return true;
            }
        });


        // Check if the user can update an entry
        $gate->define('update-entry', function ($user, $entry) {
            //log::debug("update-entry: ".$user->id ."   ". $entry->id);
            return $user->id === $entry->created_by;
        });

        // --------------------------------
        // MESSAGE GATES
        // --------------------------------

        // Check the user is part of the conversation and can therefore view it
        $gate->define('view-conversation', function ($user, $conversation) {
            if ($conversation->checkUserInConvo($user)) {
                return true;
            }
        });

        // --------------------------------
        // USER GATES
        // --------------------------------

        // Check whether the user can edit a users profile
        $gate->define('update-profile', function ($user, $profile_id) {
            //log::debug("update-profile: ".$user->id ."   ". $profile_id);
            return $user->id === $profile_id;
        });

        // Check whether the user can make an offer on an entry
        $gate->define('make-offer', function ($user, $entry, $community) {
            //log::debug("make-offer: ".$user->id ."   ". $community->name);

            return (($entry->created_by != $user->id) && $user->isMemberOfCommunity($community) && (!$entry->expired) && ($entry->completed_at == ''));
        });

        // Check whether the user can send a message to another user
        $gate->define('send-msg', function ($user, $community) {
            //log::debug("send-msg: ".$user->id ."   ". $community->name);

            return $user->isMemberOfCommunity($community);;
        });
    }
}
