<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Session;
use App\Models\Admin;


class LoginController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-12
     * 后台登录
     */
	public function login(){
		return view('admin/login/login');
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 验证码
     */
	public function captcha() {
		$builder = new CaptchaBuilder();
        $builder->build(150,32);
        $phrase = $builder->getPhrase();
        //把内容存入session
        Session::put('milkcaptcha', $phrase); //存储验证码
        ob_clean();
        return response($builder->output())->header('Content-type','image/jpeg');
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 表单验证
     */
	public function proving(){
		$admin_name = input::get('admin_name');
		$password = input::get('password');
		$captcha = input::get('code');
		$admin = new Admin;
		$data = $admin->where(['admin_name'=>$admin_name])->first();
		if(!$data){
			return 1;
		} else if($data['password'] != md5($password)){
			return 2;
		} else if(Session('milkcaptcha') != $captcha){
			return 3;
		} else if($data['start'] == 0){
			return 4;
		} else{
			session(['data'=>$data]);
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 用户退出
     */
	public function out(Request $request){
		$request->session()->forget('data'); //删除指定数据项数据
		return redirect('admin/login');
	}
}