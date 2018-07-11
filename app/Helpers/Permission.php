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
	public static function checkPermission($permission, $community) {
		$user = \Auth::user();

		if ($user->isAdminOfCommunity($community)) {
                return true;
        }
        return $user->can($permission);
	}
}