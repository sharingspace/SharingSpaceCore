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
                'author' => e($entry->author->getDisplayName()),
                'created_at' => e($entry->created_at),
                'tags' => e($entry->tags),
                'expires' => e($entry->expires),



            ];
        }
        return $entries_array;
    }
}
