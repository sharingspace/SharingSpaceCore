<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 26/12/17
 * Time: 00:14
 */

namespace App\Helpers\Wrld3D;

use App\Models\Community;
use App\Models\Entry;
use Exception;
use GuzzleHttp\Client;
use Helper;
use Illuminate\Support\Collection;

class PoiManager
{
    /**
     * @var string
     */
    private $dev_token;

    /**
     * @var string
     */
    private $api_key;

    /**
     * @var
     */
    private $poiset;

    /**
     * @var Client
     */
    private $client;
    /**
     * @var Community
     */
    private $community;

    /**
     * PoiManager constructor.
     *
     * @param Community $community
     */
    public function __construct(Community $community)
    {
        $this->community = $community;
        $this->dev_token = $community->wrld3d->get('dev_token');
        $this->api_key = $community->wrld3d->get('api_key');
        $this->poiset = $community->wrld3d->Get('poiset');

        $this->client = new Client([
            'base_uri' => config('services.wrld3d.poi_api'),
        ]);
    }

    /**
     * Request a URL to the POI API.
     *
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return Collection
     */
    public function request(string $method, string $uri, array $options = []): Collection
    {
        $options = array_merge($options, [
            'query' => array_merge(array_get($options, 'query', []), [
                'token' => $this->dev_token,
            ]),
        ]);

        $res = $this->client->request($method, $uri, $options);

        return collect([
            'statusCode' => $res->getStatusCode(),
            'content'    => $this->collectContent(json_decode($res->getBody()->getContents(), true)),
        ]);
    }

    /**
     * Associate the API Key set up for the community with a its POI Set.
     *
     * @return Collection
     */
    protected function associateApiKeyToPoiset(): Collection
    {
        return $this->request('POST', $this->poiset, [
            'json' => [
                'apikey' => $this->api_key,
            ],
        ]);
    }

    /**
     * Transform the provided data to a collection.
     *
     * @param array $data
     * @return Collection
     */
    protected function collectContent(array $data): Collection
    {
        $coll = collect($data);

        $coll->transform(function ($c) {
            if (is_array($c)) {
                return $this->collectContent($c);
            }

            return $c;
        });

        return $coll;
    }

    /**
     * Returna a list of POI sets.
     *
     * @return Collection
     */
    public function getPoisets(): Collection
    {
        $items = $this->request('GET', '', [])->get('content');

        return $items->map(function ($item) {
            return $item->get('api_key_permissions')->map(function ($apiKey) use ($item) {
                return collect([
                    'id'   => $item->get('id'),
                    'code' => $item->get('id') . ' - ' . $apiKey->get('app_api_key'),
                    'name' => $item->get('name') . ' - ' . $apiKey->get('app_api_key'),
                    'key'  => $apiKey->get('app_api_key'),
                ]);
            });
        })->flatten(1);
    }

    /**
     * Return a list of POIs in the community POI set.
     *
     * @return Collection
     */
    public function getPoiList(): Collection
    {
        return $this->request('GET', $this->poiset . '/pois/')->get('content');
    }

    public function getPoi(Entry $entry)
    {
        if (!$this->community->wrld3d || !$this->community->wrld3d->get('poiset')) {
            throw new \Exception('Community has not any POI set associated.');
        }

        if (!$entry->wrld3d || !$entry->wrld3d->get('poi_id')) {
            return null;
        }

        $res = $this->request('GET', $this->poiset . '/pois/' . $entry->wrld3d->get('poi_id'));

        return $res->get('content');
    }

    public function savePoi(Entry $entry): Collection
    {
        if (!$this->community->wrld3d || !$this->community->wrld3d->get('poiset')) {
            throw new \Exception('Community has not any POI set associated.');
        }

        $userData = [
            'entry_id'          => $entry->getKey(),
            'url'               => route('entry.view', $entry->getKey()),
            'natural_post_type' => $entry->natural_post_type,
            'author_name'       => $entry->author->display_name,
            'exchange_types'    => $entry->exchangeTypes->pluck('name')->implode(', '),
        ];

        if ($entry->media->count() && $entry->media->first()->filename) {
            $userData['image_url'] = Helper::cdn('uploads/entries/' . $entry->id . '/' . $entry->media->first()->filename);
        }

        $input = [
            'title'     => $entry->title,
            'subtitle'  => $entry->author->display_name . ' ' . $entry->natural_post_type . ' ' . $entry->title . '.',
            'tags'      => 'anyshare_entries ' . str_replace([' ', ','], ['-', ' '], $entry->tags),
            'lat'       => (float)$entry->lat,
            'lon'       => (float)$entry->lng,
            'user_data' => $userData,
        ];

        if ($entry->wrld3d->get('indoor_id')) {
            $input['indoor'] = true;
            $input['indoor_id'] = $entry->wrld3d->get('indoor_id');
            $input['floor_id'] = $entry->wrld3d->get('indoor_floor');
        }

        $method = 'POST';
        $uri = '/pois/';

        if ($poiId = $entry->wrld3d->get('poi_id')) {
            $method = 'PUT';
            $uri = '/pois/' . $poiId;
        }

        $res = $this->request($method, $this->poiset . $uri, [
            'json' => $input,
        ]);

        $entry->wrld3d = $entry->wrld3d->merge([
            'poi_id' => $res->get('content')->get('id'),
        ]);

        $entry->save();

        return $res->get('content');
    }

    public function deletePoi($id)
    {
        //
    }

    /**
     * Create a POI Set to store entries of the community.
     *
     * @return Collection
     * @throws Exception
     */
    public function createCommunityPoiset(): Collection
    {
        if (!$this->community->wrld3d->get('dev_token') || $this->community->wrld3d->get('poiset')) {
            throw new Exception('Error while creating the Sharing Network Entries POI Set');
        }

        $poiset = $this->request('POST', '', [
            'json' => [
                'name' => $this->community->name . ' - Entries POI Set',
            ],
        ]);

        // Update the community entity
        $this->community->wrld3d = $this->community->wrld3d->merge(['poiset' => $poiset->get('content')->get('id')]);
        $this->community->save();

        // Update this instance the associate the Community API Key with the its POI set.
        $this->poiset = $this->community->wrld3d->get('poiset');
        $this->associateApiKeyToPoiset();

        return $poiset;
    }
}