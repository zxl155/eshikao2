<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Gregwar\Captcha\SmsDemo;
use Illuminate\Support\Facades\Input;
use App\Home\Models\User;

class RegisterController extends Controller
{
	/**
     * @张小龙
     * @DateTime  2018-06-12
     * 前台注册
     */
	public function index(){

		return view('home/register/register');
	}

	/*张小龙
	 * @DateTime  2018-06-12
	 * 注册发送邮箱
	 */
	public function emails(){
		$phone = Input::get('phone');
		
			$code = rand(111111,999999);
			session(['phone' => $phone]);
			session(['code' => $code]);
			$ins = new SmsDemo();
			if($ins->sendSms($phone,$code)){
				echo 1;
			}else{
				echo 0;
			}
		
		
	}
	/**
     * @张小龙
     * @DateTime  2018-06-12
     * 注册验证
     */
	public function doregister()
	{
		$code = Input::get('code');
		if(session('code') != $code) {
			echo 1;
		}
	}
	/**
     * @张小龙
     * @DateTime  2018-06-12
     * 注册入库
     */
	public function addregister()
	{
		$data = Input::all();
		$phone = session('phone');
		$user = new User;
		$only = $user->only($phone);
		if ($only == 1) {
			if($data['user_tel'] == session('phone') ) {
				$data['add_time'] = date('Y-m-d H:i:s');
				$data['password'] = md5($data['user_pwd']);
				$start = $user->index($data);
				if ($start == true) {
					echo 2;
				} else {
					echo 3;
				}

			} 
		} else {
			echo 3;
		}
	}
	/**
     * @张小龙
     * @DateTime  2018-06-19
     * 忘记密码
     */
	public function retrieve()
	{
		return view('home/register/retrieve');
	}
	//通过手机号修改密码
	public function retrieves()
	{
		$data = Input::all();
		$user = new User;
		$arr = $user->retrieves($data);
		if ($arr) {
			echo 2;
		} else {
			echo 3;
		}
	}
}