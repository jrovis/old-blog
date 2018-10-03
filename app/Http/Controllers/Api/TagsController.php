<?php

namespace App\Http\Controllers\Api;

use App\Innote\Repositories\TagRepository;

class TagsController extends Controller
{
    protected $tagRepo;

    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    public function index()
    {
        return $this->tagRepo->getAllTags(request('q'));
    }
}