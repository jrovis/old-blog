<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\UserRequest;
use App\Innote\Handlers\ImageUploadHandler;
use App\Innote\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth', ['except' => ['show']]);
//        $this->middleware('single.user.login')->except(['show']);
        $this->userRepo = $userRepo;
    }

    /**
     * Display the specified resource.
     *
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($name)
    {
        $user = $this->userRepo->findUserWithTopicsByUserName($name);

        return view('home.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $user = user();

        return view('home.users.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param ImageUploadHandler $uploader
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader)
    {
        $user = user();

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $this->userRepo->update($user, $data);

        flashy()->success('个人资料更新成功！');

        return redirect($user->link());
    }
}
