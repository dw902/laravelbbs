<?php

namespace App\Observers;

use App\Models\Topic;
//在隊列中定義了
//use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
    public function saving(Topic $topic)
    {
//        xss过滤
        $topic->body = clean($topic->body, 'user_topic_body');
//        生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);


//        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译，这样容易造成错误要将下边的给saved则为可以保证￥topic有值
//        if ( ! $topic->slug) {
////            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
////            队列中执行上边的命令只是可以队列执行，更加 的有效
//            // 推送任务到队列
//            dispatch(new TranslateSlug($topic));
//        }
    }
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
