<?php

namespace App\Helpers;

use App\Models\Community;

class CommunityEntries
{
    /**
     * @var Community
     */
    protected $community;

    /**
     * @var mixed
     */
    protected $query;

    /**
     * @param Community $community
     */
    public function __construct(Community $community)
    {
        $this->community = $community;
        $this->query = $this->community->entries();
    }

    /**
     * Filter entries by user's ID.
     *
     * @param int $userId
     * @return $this
     */
    public function byUserId(int $userId)
    {
        $this->query->with('author', 'exchangeTypes', 'media')->where('created_by', $userId);
        return $this;
    }

    /**
     * Only include entries which are visible.
     *
     * @return void
     */
    public function visible()
    {
        $this->query->where('visible', 1);
        return $this;
    }

    /**
     * Only include entries which are not completed.
     *
     * @return void
     */
    public function notCompleted()
    {
        $this->query->notCompleted();
        return $this;
    }

    /**
     * Search entries containing a text string.
     *
     * @param string $search
     * @return void
     */
    public function textSearch(string $search)
    {
        $this->query->TextSearch($search);
        return $this;
    }

    /**
     * Order entries by a specific field.
     *
     * @param string $field
     * @param string $order
     * @return void
     */
    public function orderBy(string $field, string $order)
    {
        $this->query->orderBy($field, $order);
        return $this;
    }

    /**
     * Get the filtered entries.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->query->get();
    }

    public function paginate($offset, $limit) {
        return $this->query->offset($offset)
                ->limit($limit);
    }
}
