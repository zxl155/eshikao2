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


//后台
Route::group(['namespace' => 'Admin','middleware' => ['web']], function(){
  Route::group(['middleware' => 'check.login'], function() {
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
    //课程添加
    Route::get('admin/addcurr','CurriculumController@addcurr');
    //执行添加
    Route::post('admin/docurr','CurriculumController@docurr');
    //课程列表
    Route::get('admin/listcurr','CurriculumController@listcurr');
    //课程修改
    Route::get('admin/updcurr','CurriculumController@updcurr');
    //执行修改
    Route::post('admin/doupd','CurriculumController@doupd');
    //课程上架未上架
    Route::get('admin/shelf','CurriculumController@shelf');
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
    //管理员修改状态
    Route::get('admin/updates','AdminController@updates');
    //修改管理员资料
    Route::get('admin/adminUpdate','AdminController@adminUpdate');
    //执行修改管理员资料
    Route::post('admin/adminUpdates','AdminController@adminUpdates');
    //直播课程
    Route::get('admin/listpplive','PpliveController@listpplive');
    //添加直播
    Route::get('admin/addpplive','PpliveController@addpplive');
    //执行添加直播
    Route::post('admin/dopplive','PpliveController@dopplive');
    //删除直播
    Route::get('admin/delpplive','PpliveController@delpplive');
    //修改直播课程
    Route::get('admin/updpplive','PpliveController@updpplive');
    //执行修改直播课程
    Route::post('admin/updspplive','PpliveController@updspplive');
    //招聘公告
    Route::get('admin/addrecr','RecruitmentController@addrecr');
    //执行添加
    Route::post('admin/dorecr','RecruitmentController@dorecr');
    //公告列表
    Route::get('admin/listrecr','RecruitmentController@listrecr');
    //修改
    Route::get('admin/updrecr','RecruitmentController@updrecr');
    //执行修改
    Route::post('admin/updsrecr','RecruitmentController@updsrecr');
    //删除公告
    Route::get('admin/delrecr','RecruitmentController@delrecr');
    //添加轮播图
    Route::get('admin/addbro','BroadcastController@addbro');
    //执行添加
    Route::post('admin/dobro','BroadcastController@dobro');
    //轮播图列表
    Route::get('admin/listbro','BroadcastController@listbro');
    //轮播图删除
    Route::get('admin/delbro','BroadcastController@delbro');
    //执行
    Route::post('admin/updsbro','BroadcastController@updsbro');
    //助教入口
    Route::get('admin/Assistant','TeacherController@Assistant');
    //教师对应直播课程
    Route::get('admin/teacherLive','TeacherController@teacherLive');
    //教师开始直播
    Route::get('admin/teacherLives','TeacherController@teacherLives');
    //直播回放
    Route::get('admin/playback','TeacherController@playback');
  });
  //登录
  Route::get('admin/login','LoginController@login');
  //验证码
  Route::get('admin/captcha','LoginController@captcha');
  //表单验证
  Route::get('admin/proving','LoginController@proving');
  //管理员退出
  Route::get('admin/out','LoginController@out');
});
//前台
Route::group(['namespace' => 'Home'], function(){
  //前台首页
  Route::get('/','IndexController@index');
  //前台登录
  Route::get('home/login.html','LoginController@login');
  Route::post('home/dologin','LoginController@dologin');
  //忘记密码
  Route::get('home/retrieve.html','RegisterController@retrieve');
  //通过手机号修改密码
  Route::get('home/retrieves','RegisterController@retrieves');
  //注册
  Route::get('home/register.html','RegisterController@index');
  //短信发送
  Route::get('home/emails','RegisterController@emails');
  //注册验证
  Route::get('home/doregister','RegisterController@doregister');
  //注册添加入库
  Route::get('home/addregister','RegisterController@addregister');
  //个人中心我的课程
  Route::get('home/myclass.html','MyclassController@index');
  //个人中心修改个人资料
  Route::get('home/mydata.html','MydataController@index');
  //个人中心头部
  Route::get('home/head','HeadController@index');
  //个人中心进行修改个人资料
  Route::get('home/updatemydata','MydataController@updatemydata');
  //个人中心进行修改密码
  Route::get('home/updatepwd','MydataController@updatepwd');
  //个人中心进行修改密码s
  Route::get('home/updatepwds','MydataController@updatepwds');
  //个人中心进行头像
  Route::post('home/headupdate','MydataController@insetArticle');
  //教师资格
  Route::get('home/qualifications.html','QualificationsController@qualifications');
  //教师资格搜索
  Route::get('home/quasearch','QualificationsController@quaSearch');
  //教师招聘
  Route::get('home/recruit.html','RecruitController@index');
   //教师招聘
  Route::get('home/recruitsearch','RecruitController@recruitSearch');
  //未购买课程详情
  Route::get('home/coursedetails.html','CoursedetailsController@index');
  //购买之后课程详情
  Route::get('home/coursedetail.html','CoursedetailsController@coursedetail');
   //购买之后课程查看直播
  Route::get('home/coursedetailShow','CoursedetailsController@coursedetailShow');
  //查看回放
  Route::get('home/playback','CoursedetailsController@playback');
  //招聘公告列表
  Route::get('home/noticelist.html','NoticeController@index');
  //招聘公告详情
  Route::get('home/notice','NoticeController@notice');
  //招聘公告搜索
  Route::get('home/noticeSearch','NoticeController@noticeSearch');
  //优惠券
  Route::get('home/coupon.html','CouponController@index');
  //展示收货地址
  Route::get('home/address.html','AddressController@index');
  //添加收货地址
  Route::get('home/addressAdd','AddressController@addressAdd');
   //删除收货地址
  Route::get('home/addressDelete','AddressController@addressDelete');
  //修改收货地址
  Route::get('home/addressUpdate.html','AddressController@addressUpdate');
  //修改收货地址
  Route::get('home/addressUpdates.html','AddressController@addressUpdates');
   //订单首页
  Route::get('home/order.html','OrderController@index');
  //支付首页
  Route::get('home/CommodityGoods.html','CommodityController@CommodityGoods');
  //支付删除地址
  Route::get('home/CommodityAddress','CommodityController@addressDelete');
  //订单入库
  Route::get('home/orderAdd','CommodityController@orderAdd');
  //查询用户是否购买
  Route::get('home/isOrder','OrderController@isOrder');
  //查询商品数量
  Route::get('home/orderNumber','CommodityController@orderNumber');
   //支付提交
  Route::get('home/CommodityPay.html','CommodityController@CommodityPay');
   //支付 支付宝生成二维码
  Route::post('home/alipayapi','PayController@index');
  //支付 异步
  Route::get('home/asynchronous','PayController@asynchronous');
   //支付成功回调页面
  Route::get('home/apiSuccess','PayController@apiSuccess');
   //自己家的成功页面
  Route::get('home/Success','PayController@Success');
   //前台用户退出
  Route::get('home/out','LoginController@out');
   //前台用户协议
  Route::get('home/agreement.html','IndexController@agreement');
   //前台用户协议
  Route::get('home/about.html','IndexController@about');
  //前台微信支付
  Route::post('home/wxpay.html','WxpayController@index');
  //前台微信图片生成
  Route::get('home/wxpircture','WxpayController@pirctures');
   //前台微信回调成功
  Route::get('home/wxnotify.html','WxpayController@notify');
  //前台微信读秒
  Route::get('home/orderquery','WxpayController@orderquery');
  //微信支付成功页面
  Route::get('home/wxSuccess.html','WxpayController@wxSuccess');

  //移动页面通过教师资格证人气查询
  Route::get('home/popularity','QualificationsController@popularity');
  //移动页面通过教师资格证价格排序查询
  Route::get('home/moneys','QualificationsController@moneys');
  //移动页面通过教师招聘人气查询
  Route::get('home/popularitys','QualificationsController@popularitys');
  //移动页面通过教师招聘价格排序查询
  Route::get('home/moneyss','QualificationsController@moneyss');
  //移动个人中心
  Route::get('home/userlist','MyclassController@userlist');
  //移动展示收货地址
  Route::get('home/moveAddress.html','AddressController@moveAddress');
  //移动删除收货地址
  Route::get('home/moveAddressDelete','AddressController@moveAddressDelete');
  //移动修改收货地址
  Route::get('home/moveAddressUpd','AddressController@moveAddressUpd');
  //移动执行修改收货地址
  Route::get('home/moveAddressUpds','AddressController@moveAddressUpds');
  //移动添加收货地址
  Route::get('home/moveAddressInsert','AddressController@moveAddressInsert');
  //移动默认地址
  Route::get('home/movedefault','AddressController@movedefault');
  //移动修改密码
  Route::get('home/movepassword','MydataController@movepassword');
  //移动订单
  Route::get('home/moveOrder','OrderController@moveOrder');
  //移动购买
  Route::get('home/moveCoursedetails','CommodityController@moveCoursedetails');
  //移动购买地址
  Route::get('home/movePurchaseAddress','AddressController@movePurchaseAddress');
  //移动添加购买地址
  Route::get('home/movePurchaseAddressInsert','AddressController@movePurchaseAddressInsert');
});
