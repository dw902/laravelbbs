<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

//	public function store(ReplyRequest $request)
//	{
//		$reply = Reply::create($request->all());
//		return redirect()->route('replies.show', $reply->id)->with('message', 'Created successfully.');
//	}

    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
    }



    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
//        $this->authorize('destroy', $reply);
        $reply->delete();

//        return redirect()->route('replies.index')->with('success', '评论删除成功！');
        return redirect()->to($reply->topic->link())->with('success', '评论删除成功！');
    }
}
