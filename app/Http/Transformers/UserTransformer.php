<?php
namespace App\Http\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

class UserTransformer
{

    public function transform(LengthAwarePaginator $users,$community_id)
    {

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
                'role' => $role->display_name

            ];
        }
        return $users_array;

    }
}
