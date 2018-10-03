<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver
{
    /**
     * 数据保存时 触发
     *
     * @param Tag $tag
     */
    public function saving(Tag $tag)
    {
        // 指定默认的标签图标
        if (empty($tag->image)) {
            $tag->image = '/images/tags/default.jpeg';
        }
    }
}