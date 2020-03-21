<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
//表单请求验证
use App\Http\Requests\UserRequest;
//使用这个工具类
use App\Handlers\ImageUploadHandler;
class UsersController extends Controller
{
    public function __construct()
    {
//        定义只有登录用户才可以操作
        $this->middleware('auth', ['except' => ['show']]);
    }
    //使用注入的方式进行
    public function show(User $user)
    {
//        后边的为一个对象包含user中除了隐藏以外的所有的属性
        return view('users.show', compact('user'));
    }
    public function edit(User $user)
    {
//        第一个为策略名称第二个为数据
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
//            用户id为前缀save每次只保存一张图片
            $result = $uploader->save($request->avatar, 'avatars', $user->id,416);
            if ($result) {
//                通过工具类函数返回图片的地址
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
