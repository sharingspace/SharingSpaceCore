<?php

namespace App\Providers;

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
      'App\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any application authentication / authorization services.
   *
   * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    // --------------------------------
    // BEFORE ANYTHING ELSE
    // --------------------------------
    // If this condition is true, ANYTHING else below will be asssumed
    // to be true. This can cause weird blade behavior, so if something
    // happens where you don't understand why something is returning true
    // that shouldn't be true, check that the user in question
    // isn't a superadmin
    // --------------------------------


    // NOTE. gates are only called when user is logged in
    // If the user is a super admin, let them through no matter what
    Gate::before(function ($user, $ability) {
        if ($user->superadmin == '1') {
            return true;
        }
    });

    // Check if the user can see the community entries
    Gate::define('admin', function ($user) {
        if ($user->superadmin == '1') {
            return true;
        }    
    });


    // --------------------------------
    // COMMUNTIY GATES
    // --------------------------------

    // Check if the user can see the community entries
    Gate::define('view-browse', function ($user, $community) {
        //Log::debug("view-browse gate");
        if ($user->canSeeCommunity($community) || $community->group_type != 'S') {
            return true;
        }
    });

    // Check if the user can see the community about page
    Gate::define('view-about', function ($user, $community) {
        //Log::debug("view-about gate");
        // any one can see the about for an open share, even if not logged in
        if ($community->group_type !='S') {
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
    Gate::define('view-members', function ($user, $community) {
        //Log::debug("view-members gate");
        if ($community->group_type != 'S') {
            return true;
        }
    });

    // Check if the user can join a community
    // (they are not already a member)
    Gate::define('join-community', function ($user, $community) {
        //Log::debug("join-community gate");
        if (!$user->isMemberOfCommunity($community)) {
            return true;
        }
    });

    // Check if the user can update the community settings
    // (they are an admin)
    Gate::define('update-community', function ($user, $community) {
        //Log::debug("update-community gate");
        if ($user->isAdminOfCommunity($community)) {
            return true;
        }
    });



    // --------------------------------
    // ENTRY GATES
    // --------------------------------

    // Check the user is a member of the community and cam therefore post
    // an entry
    Gate::define('post-entry', function ($user, $community) {
        //Log::debug("post-entry gate");
        if ($user->isMemberOfCommunity($community)) {
            return true;
        }
    });

    // Check that the user can view an entry
    Gate::define('view-entry', function ($user, $community) {
       //Log::debug("view-entry gate");
        if (($community->group_type == 'O') || ($user->isMemberOfCommunity($community))) {
            return true;
        }
    });


    // Check if the user can update an entry
    Gate::define('update-entry', function ($user, $entry) {
        //Log::debug("update-entry gate");
        if ($user->id === $entry->created_by) {
            return true;
        }
    });

    // --------------------------------
    // MESSAGE GATES
    // --------------------------------

    // Check the user is part of the conversation and can therefore view it
    Gate::define('view-conversation', function ($user, $conversation) {
        if ($conversation->checkUserInConvo($user)) {
            return true;
        }
    });

    // --------------------------------
    // USER GATES
    // --------------------------------

    // Check whether the user can edit a users profile
    Gate::define('update-profile', function ($user, $profile_id) {
       //log::debug("update-profile gate: ".$user->id ."   ". $profile_id);
        if ($user->id === $profile_id) {
            return true;
        }
    });

    // Check whether the user can make an offer on an entry
    Gate::define('make-offer', function ($user, $entry, $community) {
       //log::debug("make-offer gate: ".$user->id ."   ". $entry->id ."   ". $community->name);
        if (($entry->created_by != $user->id) && $user->isMemberOfCommunity($community) && (!$entry->expired) && ($entry->completed_at == '')) {
            return true;
        }
    });

    // Check whether the user can send a message to another user
    Gate::define('send-msg', function ($user, $profile_id, $community) {
        //log::debug("send-msg gate user profile id ".$profile_id ."   logged in user id ".$user->id);
        if (($profile_id != $user->id) && $user->isMemberOfCommunity($community)) {
            return true;
        }
    });
  }
}
