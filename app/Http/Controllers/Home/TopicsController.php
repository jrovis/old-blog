<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\TopicRequest;
use App\Innote\Core\CreatorListener;
use App\Innote\Handlers\ImageUploadHandler;
use App\Innote\Repositories\TagRepository;
use App\Innote\Repositories\TopicRepository;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class TopicsController extends Controller implements CreatorListener
{
    protected $topicRepo;
    protected $tagRepo;

    public function __construct(TopicRepository $topicRepo, TagRepository $tagRepo)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
//        $this->middleware('single.user.login')->only(['store', 'create', 'edit', 'update']);
        $this->topicRepo = $topicRepo;
        $this->tagRepo = $tagRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, User $user)
    {
        $topics = $this->topicRepo->getAllTopicsWithAuthor($request);
//        $activeUsers = $user->getActiveUsers();
        $activeUsers = [];

        return view('home.topics.index', compact('topics', 'activeUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.topics.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TopicRequest $request
     * @return mixed
     */
    public function store(TopicRequest $request)
    {
        return $this->topicRepo->create($this, $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = $this->topicRepo->getTopicWithRelationsById($id, ['tags', 'votedUsers']);
        // 改写到 redis
        $topic->increment('views_count');

        return view('home.topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $topic = $this->topicRepo->getTopicWithRelationsById($id, 'tags');
        $this->authorize('update', $topic);

        return view('home.topics.create_edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TopicRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(TopicRequest $request, $id)
    {
        /* @var $topic Topic */
        $topic = $this->topicRepo->getTopicWithRelationsById($id, 'tags');
        $this->authorize('update', $topic);

        $this->topicRepo->update($topic, $request->all());

        return $this->createSucceeded($topic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $topic = $this->topicRepo->getTopicWithRelationsById($id, 'tags');
        $this->authorize('destroy', $topic);

        if ($this->topicRepo->delete($topic)) {
            $this->topicRepo->decTopicRelations($topic);

            flashy()->success('删除成功！');
        } else {
            flashy()->error('删除失败！');
        }

        return redirect()->route('p.index');
    }

    /**
     * 话题图片资源上传
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => '',
        ];

        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->file('file')) {
            // 保存图片到本地
            $result = $uploader->save($request->file('file'), 'topics', user()->id, false);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }

        return $data;
    }

    public function createSucceeded($topic)
    {
        flashy()->success(lang('Operation succeeded.'));

        return redirect()->to($topic->link());
    }

    public function createFailed($message)
    {
        flashy()->error('发布失败：' . $message);

        return redirect()->back();
    }
}
