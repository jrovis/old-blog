<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Innote\Repositories\TagRepository;
use App\Models\Tag;

class TagsController extends Controller
{
    protected $tagRepo;

    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $tag = $this->tagRepo->getTagById($id);
        $topics = $this->tagRepo->getTopicsByTags($id, request('filter'));

        return view('home.tags.show', compact('topics', 'tag'));
    }
}
