<?php
namespace App\Http\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

class UserTransformer
{

    public function transform(LengthAwarePaginator $users)
    {
        $users_array = array();
        foreach ($users as $user) {

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

            ];
        }
        return $users_array;

    }
}
