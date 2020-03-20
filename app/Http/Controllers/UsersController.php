<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
//表单请求验证
use App\Http\Requests\UserRequest;
class UsersController extends Controller
{
    //使用注入的方式进行
    public function show(User $user)
    {
//        后边的为一个对象包含user中除了隐藏以外的所有的属性
        return view('users.show', compact('user'));
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
