<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', 'PagesController@root')->name('root');

//Auth::routes();

Auth::routes(['verify' => true]);
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
////等同于
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');

//Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

//Route::resource('replies', 'RepliesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
//在别的地方显示不需要使用控制器
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
//通知路由器
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
