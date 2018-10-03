<?php

namespace App\Models\Queries;


trait TopicQuery
{
    /**
     * The topics lists order method.
     *
     * @param $query
     * @param $order
     * @return mixed
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'heat' :
                $query = $this->heat();
                break;
            case 'recent' :
                $query = $this->recent();
                break;
            case 'star' :
                $query = $this->star();
                break;
            default :
                $query = $this->heat();
                break;
        }

        return $query;
    }

    /**
     * 以更新时间倒序排序
     *
     * @param $query
     * @return mixed
     */
    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->latest('updated_at');
    }

    /**
     * 以创建时间倒序排序
     *
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 以热度倒叙排序 查看数目
     *
     * @param $query
     * @return mixed
     */
    public function scopeHeat($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    /**
     * 以点赞倒叙排序 查看数目
     *
     * @param $query
     * @return mixed
     */
    public function scopeStar($query)
    {
        return $query->orderBy('votes_count', 'desc');
    }

    /**
     * 过滤已删除的
     *
     * @param $query
     * @return mixed
     */
    public function scopeUndeleted($query)
    {
        return $query->where('is_delete', 0);
    }

    /**
     * 过滤隐藏的
     *
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 0);
    }

    /**
     * 根据标题检索
     *
     * @param $query
     * @param $title
     * @return mixed
     */
    public function scopeByTitle($query, $title)
    {
        if ( !$title) {
            return $query;
        }

        return $query->where('title', 'like', '%' . $title . '%');
    }
}