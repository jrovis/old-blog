<?php

namespace App\Innote\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * The user model instance.
     *
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create an user.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $this->user->fill($attributes);

        $this->user->save();

        return $this->user;
    }

    public function update($user, array $attributes)
    {
        $user->update($attributes);

        return $user;
    }

    /**
     * Find user by register source and email.
     *
     * @param $user
     * @param string $source
     * @return bool
     */
    public function findUserBySource($user, $source = User::SOURCE_GIT_HUB)
    {
        if ( !$user) {
            return false;
        }

        return $this->user->where('email', $user['email'])->where('source', $source)->first();
    }

    /**
     * Find user by username.
     *
     * @param $name
     * @return bool
     */
    public function findUserWithTopicsByUserName($name)
    {
        if ( !$name) {
            return false;
        }

        return $this->user
            ->where('username', $name)
//            ->with('topics')
//            ->with('userSocialite')
            ->firstOrFail();
    }
}