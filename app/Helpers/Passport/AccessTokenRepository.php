<?php
namespace App\Helpers\Passport;

use App\Helpers\Passport\AccessToken; // AccessToken from step 1
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Laravel\Passport\Bridge\AccessTokenRepository as PassportAccessTokenRepository;

class AccessTokenRepository extends PassportAccessTokenRepository
{
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        return new AccessToken($userIdentifier, $scopes); // AccessToken from step 1
    }
}