<?php

namespace App\Http\Controllers\Api;

use App\Innote\Repositories\TopicRepository;
use App\Innote\Vote\Vote;
use App\Models\Topic;

class TopicsController extends Controller
{
    protected $topicRepo;

    public function __construct(TopicRepository $topicRepository)
    {
        $this->middleware('auth')->only(['vote']);
        $this->middleware('single.user.login')->only(['vote']);
        $this->topicRepo = $topicRepository;
    }

    /**
     * Topic voted by user.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote($id)
    {
        $topic = $this->topicRepo->getTopicById($id);

        $topicRes = app(Vote::class)->voteTopic($topic);

        $user = user();

        return $this->successResponse([
            'voted' => $topicRes,
            'votesCount' => $topic->votes_count,
            'user' => ['link' => $user->link(), 'user' => $user->avatar],
        ]);
    }

    /**
     * Get current has voted this topic.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function voted($id)
    {
        /** @var Topic $topic */
        $topic = $this->topicRepo->getTopicWithRelationsById($id, 'votedUsers');

        $userId = user()->id;
        $voted = 0;
        collect($topic->votedUsers()->get())->each(function ($value) use($userId, &$voted) {
            if ($userId == $value->id) {
                $voted = 1;
            }
        });

        return $this->successResponse(['voted' => $voted]);
    }
    /**
     * Get all voted users of this topic .
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    private function voters($id)
    {
        /** @var Topic $topic */
        $topic = $this->topicRepo->getTopicWithRelationsById($id, 'votedUsers');

        $votedUserIds = [];
        $votedUsers = collect($topic->votedUsers()->get())->map(function ($value) use (&$votedUserIds) {
            array_push($votedUserIds, $value->id);
            return [
                'id' => $value->id,
                'userName' => $value->username,
                'name' => $value->name,
                'avatar' => $value->avatar,
            ];
        })->toArray();

        $voted = 0;
        if (in_array(user()->id, $votedUserIds)) {
            $voted = 1;
        }

        return $this->successResponse(['voted' => $voted]);
    }
}