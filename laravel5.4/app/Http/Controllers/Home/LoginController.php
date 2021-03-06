<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Gregwar\Captcha\SmsDemo;
use Illuminate\Support\Facades\Input;
use Session;
use App\Home\Models\User;


class LoginController extends Controller
{	
	
	/**
     * @张小龙
     * @DateTime  2018-06-12
     * 前台登录
     */
	public function login(){
		return view('home/login/login');
	}
	/**
     * @张小龙
     * @DateTime  2018-06-12
     * 登录验证
     */
	public function dologin(){
		$data['user_tel'] = Input::get('user_tel');
		$data['password'] = md5(Input::get('user_pwd'));
		$user = new User;
		$arr = $user->dologin($data);
		echo $arr;
	}
	//前台用户退出
	public function out(Request $request)
	{
		$request->session()->forget('user_id'); //删除指定数据项数据
		return redirect('/');
	}
	
}