<?php

/**
 * This contains some static helpers for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */

class Permission
{
	public static function checkPermission($permission, $community = "") {
		$user = \Auth::user();
		if($user) {
			if ($user->isAdminOfCommunity($community)) {
                return true;
        	}	

        	$role = $user->roles()->where('community_id', $community->id)->first();
        	if($role) {
        		$permission = $role->permissions()->where('name', $permission)->first();
        
				if($permission) {
					return true;
				}
        	}
        	
        	
		}
		return false;
	}

	public static function adminRole($user, $community = ""){
		
		if ($user->isAdminOfCommunity($community)) {
	        return true;
		}	
        return false;

	}

	public static function getSelectedRole($user , $community){
		$role = $user->roles()->where('community_id', $community->id)->first();
		
		if($role) {
			return $role->id;
		}
		
		return 0;
	}	
}