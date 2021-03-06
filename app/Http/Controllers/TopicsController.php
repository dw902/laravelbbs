<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

//	public function index()
//	{
//		$topics = Topic::with('user', 'category')->paginate(30);
//		return view('topics.index', compact('topics'));
//	}
    public function index(Request $request, Topic $topic)
    {
//        定义了排序定义了作用域在model中则这里调用定义with则为防止n+1问题
        $topics = $topic->withOrder($request->order)
            ->with('user', 'category','replies')  // 预加载防止 N+1 问题
            ->paginate(20);
        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
//	    将所有分类传递过去
        $categories = Category::all();

        return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
//	    有关联的时候使用这种方式进行保存，后边的为路由中没有传递topic参数所以为空白的对象
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
//		return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
        return redirect()->to($topic->link())->with('success', '成功创建话题！');
	}

//	public function edit(Topic $topic)
//	{
//        $this->authorize('update', $topic);
//		return view('topics.create_and_edit', compact('topic'));
//	}
    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

//		return redirect()->route('topics.show', $topic->id)->with('success', '更新成功');
        return redirect()->to($topic->link())->with('success', '更新成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

        return redirect()->route('topics.index')->with('success', '成功删除！');
	}
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
