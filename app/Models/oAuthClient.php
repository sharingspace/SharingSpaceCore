<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class oAuthClient extends Model
{
    protected $table = 'oauth_clients';


	public function community_apis()
	{	    
	     return $this->belongsToMany('App\Models\Community', 'community_apis','oauth_clients_id', 'community_id');
	}
}