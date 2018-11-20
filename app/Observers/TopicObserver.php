<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Models\Topic;
use App\Innote\Traits\Markdown;

/**
 * Topic Eloquent Model 观察器
 * Class TopicObserver
 *
 * @package App\Observers
 */
class TopicObserver
{
    use Markdown;

    /**
     * 数据保存时 触发
     *
     * @param Topic $topic
     */
    public function saving(Topic $topic)
    {
        // 过滤特殊字符
//        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
        $topic->body_original = $topic->body;
        $topic->body = $this->convertMarkdownToHtml($topic->body);
    }

    /**
     * 数据保存后触发
     *
     * @param Topic $topic
     */
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( !$topic->slug) {
            // 推送任务到队列中
//            dispatch(new TranslateSlug($topic));
        }
    }
}