<?php

namespace App\Helpers;
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
	public static function checkPermission($permission) {
		
        if(\Auth::user()->role_assigned == 1) {
            return \Auth::user()->can($permission);    
        }
        return  true;
	}
}