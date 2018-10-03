<?php

namespace App\Innote\Repositories;

use App\Innote\Core\CreatorListener;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class TopicRepository extends BaseRepository
{
    /**
     * The user model instance.
     *
     * @var User
     */
    protected $user;

    /**
     * The topic model instance.
     *
     * @var Topic
     */
    protected $topic;

    /**
     * The tag model instance.
     *
     * @var Tag
     */
    protected $tag;

    /**
     * TopicRepository constructor.
     *
     * @param Topic $topic
     * @param Tag $tag
     */
    public function __construct(Topic $topic, Tag $tag)
    {
        $this->topic = $topic;
        $this->tag = $tag;
    }

    /**
     * Get all topics.
     *
     * @param Request $request
     * @param int $pageSize
     * @param bool $showAll
     * @return mixed
     */
    public function getAllTopicsWithAuthor(Request $request, $pageSize = 20, $showAll = false)
    {
        $title = ($request->has('q') && $request->get('q')) ? $request->get('q') : '';

        $resource = $this->topic->withOrder($request->filter)
            ->byTitle($title);

        if (! $showAll) $resource->undeleted()->published();

        return $resource->with('user')
            ->paginate($pageSize);
    }

    /**
     * Get topic with tags by topic id.
     *
     * @param $id
     * @param string|array $relations
     * @param bool $showAll
     * @return mixed
     */
    public function getTopicWithRelationsById($id, $relations, $showAll = false)
    {
        $id = $this->hashIdDecode($id);
        if ($id === null) throw new \UnexpectedValueException();
        $resource = $this->topic->where('id', $id);

        if (is_string($relations)) {
            $resource->with($relations);
        } else if (is_array($relations) && ! empty($relations)) {
            foreach ($relations as $relation) {
                $resource->with($relation);
            }
        }

        if (! $showAll) $resource->undeleted();

        return $resource->firstOrFail();
    }

    /**
     * Get topic by topic id.
     *
     * @param $id
     * @param bool $showAll
     * @return mixed
     */
    public function getTopicById($id, $showAll = false)
    {
        $id = $this->hashIdDecode($id);
        if ($id === null) throw new \UnexpectedValueException();
        $resource = $this->topic->where('id', $id);

        if (! $showAll) $resource->undeleted();

        return $resource->firstOrFail();
    }

    /**
     * Create a topic.
     *
     * @param CreatorListener $observer
     * @param array $attributes
     * @return mixed
     */
    public function create(CreatorListener $observer, array $attributes)
    {
        if ($this->isDuplicate($attributes)) {
            return $observer->createFailed(lang('Do not post duplicate topics!'));
        }

        $this->topic->fill($attributes);
        $this->topic->user_id = user()->id;
        $this->topic->last_reply_user_id = 0;

        $this->topic->save();

        $tags = $this->normalizeTagsOnCreate($attributes['tags']);
        $this->topic->tags()->attach($tags);

        $this->topic->user()->increment('topics_count');

        return $observer->createSucceeded($this->topic);
    }

    /**
     * Update topic.
     *
     * @param $topic
     * @param array $attributes
     * @return mixed
     */
    public function update($topic, array $attributes)
    {
        $tags = $this->normalizeTagsOnUpdate($attributes['tags'], $topic);

        $topic->fill($attributes);

        $topic->tags()->sync($tags);

        return $topic->update($attributes);
    }

    /**
     * Delete topic  update topic column is_delete.
     *
     * @param $topic
     * @return mixed
     */
    public function delete($topic)
    {
        $topic->is_delete = Topic::IS_DELETE;

        return $topic->save();
    }

    /**
     * 新建话题时 规范 tag id.
     *
     * @param array $tags
     * @return array
     */
    public function normalizeTagsOnCreate(array $tags)
    {
        return collect($tags)->map(function ($tag) {
            if (is_numeric($tag)) {
                // 文章数目 递增
                $this->tag->findOrFail($tag)->increment('topics_count');
                return (int)$tag;
            }

            return $this->getTagIdByNameOrCreate($tag);
        })->toArray();
    }

    /**
     * 更新话题时 规范 tags id.
     *
     * @param array $tags
     * @param $topic
     * @return array
     */
    public function normalizeTagsOnUpdate(array $tags, $topic)
    {
        $tags = collect($tags)->map(function ($tag) {
            if (is_numeric($tag)) {
                return (int)$tag;
            }
            return $this->getTagIdByNameOrCreate($tag);
        })->toArray();

        $oldTagIds = $topic->tags()->pluck('tags.id')->toArray();
        $incrementIds = [];
        foreach ($tags as $tag) {
            if (! in_array($tag, $oldTagIds)) {
                $incrementIds[] = $tag;
            }
        }
        if (! empty($incrementIds)) $this->tag->whereIn('id', $incrementIds)->increment('topics_count');

        $decrementIds = [];
        foreach ($oldTagIds as $id) {
            if (! in_array($id, $tags)) {
                $decrementIds[] = $id;
            }
        }
        if (! empty($decrementIds)) $this->tag->whereIn('id', $decrementIds)->decrement('topics_count');

        return $tags;
    }

    /**
     * Get tag id By tag name or create new tag.
     *
     * @param $tag
     * @return mixed
     */
    private function getTagIdByNameOrCreate($tag)
    {
        $oldTag = $this->tag->where('name', $tag)->first();
        if ($oldTag) {
            return $oldTag->id;
        }

        $tagModel = new Tag();
        $tagModel->fill(['name' => $tag, 'description' => $tag, 'topics_count' => 1, 'creator' => user()->id]);
        $tagModel->save();

        return $tagModel->id;
    }

    /**
     * Topic relation models decrement column topics_count.
     *
     * @param $topic
     * @return bool
     */
    public function decTopicRelations($topic)
    {
        $topic->user()->decrement('topics_count');

        $tagIds = $topic->tags()->pluck('tag_id');
        $this->tag->where('id', $tagIds)->decrement('topics_count');

        return true;
    }

    /**
     * Check for duplicate.
     *
     * @param $data
     * @return bool
     */
    private function isDuplicate($data)
    {
        $lastTopic = $this->topic->where('user_id', user()->id)
            ->orderBy('id', 'desc')
            ->first();

        return (! empty($lastTopic)) && strcmp($lastTopic->title, $data['title']) === 0;
    }

    /**
     * Decode hash id.
     *
     * @param $id
     * @return mixed
     */
    private function hashIdDecode($id)
    {
        return hashIdDecode($id);
    }
}