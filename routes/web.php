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
Route::any('/wechat', 'WeChatController@serve');

Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/', 'ChatController@index');
    Route::get('/home', 'ChatController@index');
    Route::get('/chat', 'ChatController@index');
    Route::post('/chat/robot', 'ChatController@robot');
    Route::get('/user/index', 'UserController@index');
    Route::post('/user/config', 'UserController@config');
});

