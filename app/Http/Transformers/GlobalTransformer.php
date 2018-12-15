<?php
namespace App\Http\Transformers;

use App\Models\Community;
use App\Models\User;

class GlobalTransformer
{
	/*
	 * Transform the database to array of communities
	 */
	public static function transform_allcommunities($communities) {
		$communities_array = array();
        foreach ($communities as $community) {
            $communities_array[] = [
                'id' => e($community->id),
	            'name' => e($community->name),
	            'about' => e($community->about),
		            'location' =>
	                [
	                  'name' => e($community->location),
	                  'latitude' => e($community->latitude),
	                  'longitude' => e($community->longitude),
	                ],
	            'members' => e($community->members->count()),
	            'total' => $communities->total(),
                'lastpage' => $communities->lastpage(),
            ];
        }
        return $communities_array;

	}
    public static function transform_allexchnge_types($exchangeTypes) {
        $exchange_types = array();
        foreach ($exchangeTypes as $value) {
            $exchange_types[$value->id] = $value->name;
        }
        return $exchange_types;

    }
    public static function transformgetAllPermissions($permissions) {
        foreach ($permissions as $permission) {
            $permissions_array[$permission->id] = $permission->display_name;
        }

        return $permissions_array;

    }

	/*
	 * Transform the database to array of entries
	 */
	public static function transform_entries($entries) {
		$entries_array = array();
        foreach ($entries as $entry) {
            if(is_null($entry->author)) {
                $author = '';
            } else {
                $author = e($entry->author->getDisplayName());
            }
            $entries_array[] = [
                'id' => e($entry->id),
                'title' => e($entry->title),
                'post_type' => e($entry->post_type),
                'description' => e($entry->description),
                'location' =>
                    [
                        'name' => e($entry->location),
                        'latitude' => e($entry->latitude),
                        'longitude' => e($entry->longitude),
                    ],
                'author' => $author,
                'created_at' => e($entry->created_at),
                'tags' => e($entry->tags),
                'expires' => e($entry->expires),
                'total' => $entries->total(),
                'lastpage' => $entries->lastpage(),
            ];
        }
        return $entries_array;
	}

	/*
	 * Transform the database to array of members
	 */
	public static function transformall_members($users, $community_id) {
		$users_array = array();
        foreach ($users as $user) {
            $role_name = '';
            $role = $user->roles()->where('community_id', $community_id)->first();
            if(!empty($role)) {
                $role_name = $role->display_name;
            }
            $users_array[] = [
                'id' => e($user->id),
                'profile_images' =>
                    [
                        'avatar' => e($user->imagefile),
                        'cover' => e($user->cover_img),
                    ],
                'first_name' => e($user->first_name),
                'last_name' => e($user->last_name),
                'display_name' => e($user->display_name),
                'bio' => e($user->bio),
                'location' =>
                    [
                        'name' => e($user->location),
                        'latitude' => e($user->latitude),
                        'longitude' => e($user->longitude),
                    ],
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'total' => $users->total(),
                'lastpage' => $users->lastpage(),

            ];
        }
        return $users_array;
	}

	/*
	 * Transform the database to array of roles
	 */
	public static function transformall_allroles($roles) {
		foreach ($roles as $role) {
            $roles_array[] = [
                'id' => e($role->id),
	            'display_name' => e($role->display_name),
	            'total' => $roles->total(),
                'lastpage' => $roles->lastpage(),
            ];
        }
        return $roles_array;
	}

	
}