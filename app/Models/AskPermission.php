<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class AskPermission extends Model
{
	protected $table = 'member_requests';
	
    protected $fillable = [
    						'request_type',
    						'community_id',
    						'user_id',
						    'role_id',
						    'is_accepted',
						    'is_rejected',
						    'custom_text',
						];



	public function user()
	{
		return $this->belongsTo('App\Models\User');
	} 

	public function role()
	{
		return $this->belongsTo('Spatie\Permission\Models\Role');
	}
}
