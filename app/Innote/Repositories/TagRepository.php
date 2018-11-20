<?php

namespace App\Innote\Repositories;

use App\Models\Tag;
use App\Models\Topic;

class TagRepository extends BaseRepository
{
    protected $topic;
    protected $tag;

    public function __construct(Topic $topic, Tag $tag)
    {
        $this->topic = $topic;
        $this->tag = $tag;
    }

    /**
     * Get all tags [Search by tag name]
     *
     * @param $name
     * @return mixed
     */
    public function getAllTags($name)
    {
        return Tag::select(['id', 'name'])
            ->where('name', 'like', '%' . $name . '%')
            ->get();
    }

    /**
     * Get all topics with current tag.
     *
     * @param $tagId
     * @param $order
     * @param int $pageSize
     * @return mixed
     */
    public function getTopicsByTags($tagId, $order, $pageSize = 20)
    {
        return $this->topic
            ->with('user')
            ->withOrder($order)
            ->undeleted()
            ->whereHas('tags', function($query) use ($tagId) {
                $query->where('tag_id', $tagId);
            })
            ->paginate($pageSize);
    }

    /**
     * Get tag by tag id.
     *
     * @param $id
     * @return mixed
     */
    public function getTagById($id)
    {
        return $this->tag->where('id', $id)->firstOrFail();
    }

    public function create($tag)
    {
        $this->tag->fill(['name' => $tag, 'description' => $tag, 'topics_count' => 1, 'creator' => user()->id]);
        $this->topic->save();

        return $this->topic;
    }
}