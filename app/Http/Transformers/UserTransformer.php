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
                'id' => $user->id,
                'profile_images' =>
                    [
                        'avatar' => $user->imagefile,
                        'cover' => $user->cover_img,
                    ],
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'display_name' => $user->display_name,
                'bio' => $user->bio,
                'location' =>
                    [
                        'name' => $user->location,
                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,
                    ],
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,

            ];
        }
        return $users_array;

    }
}
