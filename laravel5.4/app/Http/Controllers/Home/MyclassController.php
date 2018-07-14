<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\UserCurriculum;

class MyclassController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台个人中心我的课程
     */
	public function index(){
		$user_id = session('user_id');
	 	$usercurriculum = new UserCurriculum;
	 	$curriculum = $usercurriculum->index($user_id);
	 	if ($curriculum==false) {
	 		return view('home/personal/personal',[
				"curriculum"=>1,
			]);die;
	 	}
		return view('home/personal/personal',[
			"curriculum"=>$curriculum,
		]);
	}
	/**
     * @
     * @DateTime  2018-07-14 移动版个人中心
     * 前台个人中心
     */
	public function userlist(){
	   	$user_id = session('user_id');
	   	if ($user_id) {
	   		return view('home/personal/userlist');
	   	} else {
	   		return redirect('home/login.html');
	   	}
		
	}
}