<?php
namespace App\Http\Transformers;

use App\Community;
use App\User;

class CommunityTransformer
{

    public function transform(Community $community)
    {
        return [
            'id' => $community->hubgroup_id,
            'name' => $community->name,
            'about' => $community->about,
            'created_at' => $community->created_at,
            'updated_at' => $community->created_at,
            'location' =>
                [
                  'name' => $community->location,
                  'latitude' => $community->latitude,
                  'longitude' => $community->longitude,
                ],
            'members' => $community->members->count(),
        ];
    }
}

class MemberlistTransformer
{

    public function transform(User $members)
    {
        return [
          'id' => $members->id,
          'name' => $members->getDisplayName(),
          'admin' => $members->is_admin,

        ];
    }
}
