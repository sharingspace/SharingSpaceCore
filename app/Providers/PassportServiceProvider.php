<?php

namespace App\Providers;

use League\OAuth2\Server\AuthorizationServer;

class PassportServiceProvider extends \Laravel\Passport\PassportServiceProvider
{
    public function makeAuthorizationServer()
    {
        return new AuthorizationServer(
            $this->app->make(\Laravel\Passport\Bridge\ClientRepository::class),
            $this->app->make(\App\Helpers\Passport\AccessTokenRepository::class), // AccessTokenRepository from step 2
            $this->app->make(\Laravel\Passport\Bridge\ScopeRepository::class),
            $this->makeCryptKey('oauth-private.key'),
            app('encrypter')->getKey()
        );
    }

}