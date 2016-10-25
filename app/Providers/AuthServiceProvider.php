<?php

namespace App\Providers;

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
        $gate->before(function ($user, $ability) {
            if ($user->superadmin=='1') {
                return true;
            }
        });

        // Check if the user can see the community entries
        $gate->define('admin', function ($user) {
            if ($user->superadmin=='1') {
                return true;
            }
        });

        // --------------------------------
        // COMMUNTIY GATES
        // --------------------------------

        // Check if the user can see the community entries
        $gate->define('view-browse', function ($user, $community) {
          //Log::debug("view-browse ************** view-browse entered user id = ".$user->id.',   community id = '.$community->id.$community->name);

          if ($user->canSeeCommunity($community)) {
            //Log::debug("view-browse ************** can view view-browse");
            return true;
          }
          //Log::debug("view-browse ************** cannot view view-browse");
        });

        // Check if the user can see the community about page
        $gate->define('view-about', function ($user, $community) {
          //Log::debug("view-about ************** entered");

          if(($community->group_type=='O') || ($user->isMemberOfCommunity($community) || $user->isSuperAdmin() || $community->group_type!='S')) { 
            if (strlen($community->about)) {
              //Log::debug("view-about ************** can view");
              return true;
            }
            //Log::debug("view-about ************** cannot view");
          }
        });

        //@elseif (strlen($whitelabel_group->about) && 
        //      ($whitelabel_group->scopeIsPublic() || (Auth::check() && !Auth::user()->isMemberOfCommunity($whitelabel_group))))

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
            if ($user->isAdminOfCommunity($community) ) {
                return true;
            }
        });



        // --------------------------------
        // ENTRY GATES
        // --------------------------------

        // Check the user is a member of the community and cam therefore post
        // an entry
        $gate->define('post-entry', function ($user, $community) {
          if ($user->isMemberOfCommunity($community)) {
              return true;
          }
        });

        // Check that the user can view an entry
        $gate->define('view-entry', function ($user, $community) {
          if (($community->group_type=='O') || ($user->isMemberOfCommunity($community))) {
              return true;
          }
        });


        // Check if the user can update an entry
        $gate->define('update-entry', function ($user, $entry) {
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
    }
}
