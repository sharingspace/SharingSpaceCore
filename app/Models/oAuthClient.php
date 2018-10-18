<?php

namespace App\Models;

use Laravel\Passport\Client;

class oAuthClient extends Client
{

	public function community_apis()
	{	    
	     return $this->belongsToMany('App\Models\Community', 'community_apis','oauth_clients_id', 'community_id');
	}
}