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
    // If the user is a super admin, let them through no matter what
    Gate::before(function ($user, $ability) {
        return $user->superadmin;
    });

    // Check if the user can see the community entries
    Gate::define('admin', function ($user) {
        return $user->superadmin;
    });


    // --------------------------------
    // COMMUNTIY GATES
    // --------------------------------

    // Check if the user can see the community entries
    Gate::define('view-browse', function ($user, $community) {
        return ($user->canSeeCommunity($community) || $community->group_type != 'S');
    });

    // Check if the user can see the community about page
    Gate::define('view-about', function ($user, $community) {
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
        
        return false;
    });

    // Check if the user can see the community members page
    Gate::define('view-members', function ($user, $community) {
        return ($community->group_type != 'S');
    });

    // Check if the user can join a community
    // (they are not already a member)
    Gate::define('join-community', function ($user, $community) {
        return !$user->isMemberOfCommunity($community);
    });

    // Check if the user can update the community settings
    // (they are an admin)
    Gate::define('update-community', function ($user, $community) {
        return $user->isAdminOfCommunity($community);
    });



    // --------------------------------
    // ENTRY GATES
    // --------------------------------

    // Check the user is a member of the community and cam therefore post
    // an entry
    Gate::define('post-entry', function ($user, $community) {
      return $user->isMemberOfCommunity($community);
    });

    // Check that the user can view an entry
    Gate::define('view-entry', function ($user, $community) {
      return (($community->group_type == 'O') || ($user->isMemberOfCommunity($community)));
    });


    // Check if the user can update an entry
    Gate::define('update-entry', function ($user, $entry) {
        return ($user->id === $entry->created_by);
    });

    // --------------------------------
    // MESSAGE GATES
    // --------------------------------

    // Check the user is part of the conversation and can therefore view it
    Gate::define('view-conversation', function ($user, $conversation) {
        return $conversation->checkUserInConvo($user);
    });

    // --------------------------------
    // USER GATES
    // --------------------------------

    // Check whether the user can edit a users profile
    Gate::define('update-profile', function ($user, $profile_id) {
        //log::debug("update-profile **************: ".$user->id ."   ". $profile_id);
        return ($user->id === $profile_id);
    });

    // Check whether the user can make an offer on an entry
    Gate::define('make-offer', function ($user, $entry, $community) {
        //log::debug("make-offer **************: ".$user->id ."   ". $entry->id ."   ". $community->name);

        return (($entry->created_by != $user->id) && $user->isMemberOfCommunity($community) && (!$entry->expired) && ($entry->completed_at == ''));
    });

    // Check whether the user can send a message to another user
    Gate::define('send-msg', function ($user, $profile_id, $community) {
        //log::debug("send-msg ************** user profile id ".$profile_id ."   logged in user id ".$user->id);
        return ($profile_id != $user->id) && $user->isMemberOfCommunity($community);
    });
  }
}
