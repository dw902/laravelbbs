<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UsersController extends Controller
{
    //使用注入的方式进行
    public function show(User $user)
    {
//        后边的为一个对象包含user中除了隐藏以外的所有的属性
        return view('users.show', compact('user'));
    }
}
