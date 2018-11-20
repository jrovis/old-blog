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
Auth::routes();

Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'TopicsController@index')->name('root');
    Route::get('users/profile', 'UsersController@profile')->name('users.profile');  // 修改资料
    Route::resource('users', 'UsersController', ['only' => ['show', 'update']]);
    Route::resource('p', 'TopicsController');
    Route::resource('t', 'TagsController', ['only' => ['show']]);
    Route::post('upload_image', 'TopicsController@uploadImage')->name('p.upload_image');   // 图片上传
});


