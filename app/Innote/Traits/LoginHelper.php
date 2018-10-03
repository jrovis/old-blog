<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait LoginHelper
{
    /**
     * @return string
     */
    public function createSingleToken()
    {
        $time = time();
        // md5 加密
        $singleToken = md5(request()->getClientIp() . auth()->id() . $time);
        // 当前 time 存入 Redis
        Redis::set('innote:single_user_login_' . auth()->id(), $time);

        return $singleToken;
    }
}