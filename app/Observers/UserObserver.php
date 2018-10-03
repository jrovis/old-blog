<?php

namespace App\Observers;

use App\Models\User;

/**
 * User Eloquent Model 观察器
 * Class UserObserver
 *
 * @package App\Observers
 */
class UserObserver
{
    /**
     * 数据保存时 触发
     *
     * @param User $user
     */
    public function saving(User $user)
    {
        // 才指定默认头像
        if (empty($user->avatar)) {
            $user->avatar = config('app.url') . '/images/avatars/default.jpg';
        }

        if (empty($user->name)) {
            $user->name = '';
        }
    }
}