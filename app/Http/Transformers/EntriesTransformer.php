<?php
namespace App\Http\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

class EntriesTransformer
{

    public function transform(LengthAwarePaginator $entries)
    {
        $entries_array = array();
        foreach ($entries as $entry) {

            $entries_array[] = [
                'id' => $entry->id,
                'title' => $entry->title,
                'post_type' => $entry->post_type,
                'description' => $entry->description,
                'location' =>
                    [
                        'name' => $entry->location,
                        'latitude' => $entry->latitude,
                        'longitude' => $entry->longitude,
                    ],
                'author' => $entry->author->getDisplayName(),
                'created_at' => $entry->created_at,
                'tags' => $entry->tags,
                'expires' => $entry->expires,



            ];
        }
        return $entries_array;
    }
}
