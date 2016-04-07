<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        // If the user is a super admin, let them through no matter what
        $gate->before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        $gate->define('view-entry', function ($user, $community) {
          if (($community->group_type=='O') || ($user->isMemberOfCommunity($community))) {
              return true;
          }
        });

        $gate->define('view-browse', function ($user, $community) {
          if ($user->canSeeCommunity($community)) {
              return true;
          }
        });

        $gate->define('update-entry', function ($user, $entry) {
            return $user->id === $entry->created_by;
        });

        $gate->define('update-community', function ($user, $community) {
            if( $user->isAdminOfCommunity($community) ) {
                return true;
            }
        });

    }
}
