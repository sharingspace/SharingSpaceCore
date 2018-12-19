<?php
namespace App\Helpers\Passport;

use Laravel\Passport\Bridge\AccessToken as PassportAccessToken;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server\CryptKey;
use Illuminate\Http\Request;
use App\Models\oAuthClient;


class AccessToken extends PassportAccessToken {

    // public function convertToJWT(CryptKey $privateKey)
    // {

    //     return (new Builder())
    //         ->setAudience($this->getClient()->getIdentifier())
    //         ->setId($this->getIdentifier(), true)
    //         ->setIssuedAt(time())
    //         ->setNotBefore(time())
    //         ->setExpiration($this->getExpiryDateTime()->getTimestamp())
    //         ->setSubject($this->getUserIdentifier())
    //         ->set('scopes', $this->getScopes())
    //         ->set('community', $this->getDefaultSettings()) // my custom claims
    //         ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
    //         ->getToken();
    // }

   
    // public function getCommunity() {
    //     $user = oAuthClient::find($this->getClient()->getIdentifier());

        
    //     $community = $user->community_apis->first();

    //     if(!empty($community)) {    
    //         return [
    //             'community_id' => $community->id,
    //             'user_id'      => $user->id
    //         ];
    //     }
    //         return [
    //             'community_id' => 0,
    //             'user_id'      => $user->id
    //         ];


        
    // }

    // public function getDefaultSettings() {
        
    // }
}