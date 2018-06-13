<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\User;

class IndexController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台首页张晓龙
     */
	public function index(){
		$user_id = session('user_id');
		if (!empty($user_id)) {
			$user = new User;
			$user = $user->oneuser($user_id);
			if ($user == false) {
				echo "用户登录操作失败";die;
			} else {
				if ($user[0]->user_name == "") {
				$data = $user[0]->user_tel;
				} else {
					$data = $user[0]->user_name;
				}
			}
			
			return view('home/index/index',['user' => $data]);
		} else {
			return view('home/index/index');
		}
		
	}
}