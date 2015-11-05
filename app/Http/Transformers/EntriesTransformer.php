<?php
namespace App\Http\Transformers;
use \App\Entry;


class EntriesTransformer {

    public function transform(Entry $entry) {
        return [
            'id' => $entry->tile_id,
            'title' => $entry->title,
            'description' => $entry->description,
            'type' => $entry->post_type,
            'location' =>
                [
                  'name' => $entry->location,
                  'latitude' => $entry->latitude,
                  'longitude' => $entry->longitude,
                ],
            'author' => $entry->author->fullName(),
            'created_at' => $entry->created_at,
            'tags' => $entry->tags,
            'expires' => $entry->expires,



        ];
    }


}
