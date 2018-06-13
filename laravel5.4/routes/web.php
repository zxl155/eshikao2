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
//后台
Route::group(['namespace' => 'Admin'], function(){
	//后台首页
  Route::get('admin/index','IndexController@index');
  //个人中心
  Route::get('admin/personal','IndexController@personal');
  //修改资料
  Route::get('admin/upd','IndexController@upd');
  //执行修改资料
  Route::post('admin/upds','IndexController@upds');
  //修改密码
  Route::get('admin/pwd','IndexController@pwd');
  //执行修改密码
  Route::get('admin/pwds','IndexController@pwds');
  //登录
  Route::get('admin/login','LoginController@login');
  //验证码
  Route::get('admin/captcha','LoginController@captcha');
  //表单验证
  Route::get('admin/proving','LoginController@proving');
  //管理员退出
  Route::get('admin/out','LoginController@out');
  //课程添加
  Route::get('admin/addcurr','CurriculumController@addcurr');
  //执行添加
  Route::post('admin/docurr','CurriculumController@docurr');
  //课程列表
  Route::get('admin/listcurr','CurriculumController@listcurr');
  //课程修改
  Route::get('admin/updcurr','CurriculumController@updcurr');
  //课程删除
  Route::get('admin/delcurr','CurriculumController@delcurr');
  //管理员添加
  Route::get('admin/addadmin','AdminController@addadmin');
  //执行添加
  Route::post('admin/doadmin','AdminController@doadmin');
  //管理员列表
  Route::get('admin/listadmin','AdminController@listadmin');
  //管理员删除
  Route::get('admin/del','AdminController@del');
});
//前台
Route::group(['namespace' => 'Home'], function(){
  //前台首页
  Route::get('home/index','IndexController@index');
  //前台登录
  Route::get('home/login','LoginController@login');
  Route::post('home/dologin','LoginController@dologin');
  //注册
  Route::get('home/register','RegisterController@index');
  //短信发送
  Route::get('home/emails','RegisterController@emails');
  //注册验证
  Route::get('home/doregister','RegisterController@doregister');
  //注册添加入库
  Route::get('home/addregister','RegisterController@addregister');
  //个人中心我的课程
  Route::get('home/myclass','MyclassController@index');
  //个人中心修改个人资料
  Route::get('home/mydata','MydataController@index');
  //个人中心进行修改个人资料
  Route::get('home/updatemydata','MydataController@updatemydata');
  //个人中心进行修改密码
  Route::get('home/updatepwd','MydataController@updatepwd');
  //个人中心进行修改密码s
  Route::get('home/updatepwds','MydataController@updatepwds');
  //教师资格
  Route::get('home/qualifications','QualificationsController@qualifications');
  //教师资格详情页
  Route::get('home/viewdetails','QualificationsController@viewdetails');
});
