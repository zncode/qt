<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::get('/', 				            'IndexController/index');
Route::get('admin/resource', 				'IndexController/resource_list');

//文章
Route::get('admin/article/add', 			'ArticleController/add_form');
Route::post('admin/article/add_submit', 	'ArticleController/add_form_submit');
Route::get('admin/article/edit', 			'ArticleController/edit_form');
Route::post('admin/article/edit_submit', 	'ArticleController/edit_form_submit');
Route::get('admin/article/list', 			'ArticleController/index');
Route::get('admin/article/info', 			'ArticleController/info');
Route::get('admin/article/delete', 		'ArticleController/delete');

//文章类型
Route::get('admin/article_type/add', 			'CategoryController/add_form');
Route::post('admin/article_type/add_submit', 	'CategoryController/add_form_submit');
Route::get('admin/article_type/edit', 			'CategoryController/edit_form');
Route::post('admin/article_type/edit_submit', 	'CategoryController/edit_form_submit');
Route::get('admin/article_type/list', 			'CategoryController/index');
Route::get('admin/article_type/info', 			'CategoryController/info');
Route::get('admin/article_type/delete', 		'CategoryController/delete');

//频道
Route::get('admin/channel/add', 			'ChannelController/add_form');
Route::post('admin/channel/add_submit', 	'ChannelController/add_form_submit');
Route::get('admin/channel/edit', 			'ChannelController/edit_form');
Route::post('admin/channel/edit_submit', 	'ChannelController/edit_form_submit');
Route::get('admin/channel/list', 			'ChannelController/index');
Route::get('admin/channel/info', 			'ChannelController/info');
Route::get('admin/channel/delete', 		'ChannelController/delete');

//栏目
Route::get('admin/channel/add', 			'ChannelController/add_form');
Route::post('admin/channel/add_submit', 	'ChannelController/add_form_submit');
Route::get('admin/channel/edit', 			'ChannelController/edit_form');
Route::post('admin/channel/edit_submit', 	'ChannelController/edit_form_submit');
Route::get('admin/channel/list', 			'ChannelController/index');
Route::get('admin/channel/info', 			'ChannelController/info');
Route::get('admin/channel/delete', 		'ChannelController/delete');

Route::get('admin/article/test', 		'ArticleController/test');

include 'route_api.php';